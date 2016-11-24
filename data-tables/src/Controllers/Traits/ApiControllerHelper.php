<?php

namespace Topicmine\DataTables\Controllers\Traits;

use JWTAuth;
use Illuminate\Http\Request;
use Request as RequestFacade;
use App\Exceptions\GeneralException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Topicmine\Core\Models\Account\AccountDatabaseModel;

trait ApiControllerHelper {

    use ValidatesRequests;

    public $controllerPath;

    public $relation;

    public $repoPath;

    public $requestPath;

    public $repo;

    public function getRepo()
    {
        // Don't want to make repo for system calls e.g. composer dump-autoload
        // so check to see if repo has been set by the controller
        if($this->getRepoPath()) {
            return repo()->make($this->getRepoPath());
        }

        return false;
    }

    public function getRepoPath()
    {
        return $this->repoPath;
    }

    public function upgradeModelConnection()
    {
        $this->middleware(function ($request, $next) {

            $this->repo = $this->getRepo();

            // AccountDatabaseModel is the model which, if extended. will automatically set
            // the connection to the appropriate database
            if (is_subclass_of($this->repo->modelBase, AccountDatabaseModel::class)) {
                $this->repo->modelBase->setConnection(account()->userDatabaseConnectionKey());
            }

            $this->modelName = model_heading($this->repo->modelBase);

            return $next($request);
        });
    }

    public function setModelRelationIfExists()
    {
        if(RequestFacade::header('Relation-Parent-Repo') == false ||
            RequestFacade::header('Relation-Relationship') == false ) {
            return;
        }

        $this->relation['parentRepo'] = RequestFacade::header('Relation-Parent-Repo');
        $this->relation['relationship'] = RequestFacade::header('Relation-Relationship');
        $this->relation['parentId'] = RequestFacade::header('Relation-Parent-Id');

        // not sure why this is here - to review
//        $this->setting = false;

        if(! empty($this->relation['relationship']) &&
            $this->relation['relationship'] != 'null' &&
            $this->relation['parentId'] != 'null'
        ) {
            // not sure why this is here - to review
//            $this->setting = true;
//            $this->relation['set'] = true;

            $relation = $this->relation;
            $this->middleware(function ($request, $next) use ($relation) {

                // Set the relationship in the repository
                $this->repo->setModelWithRelation($relation['parentRepo'], $relation['relationship'], $relation['parentId']);
                return $next($request);
            });
        }
    }

    public function setRepoPath()
    {
        $this->repoPath = RequestFacade::header('Site-Repo-Path');
        $this->repo = $this->getRepo();

        // Will always look for requests matching the same file structure as the repository. If
        // there isn't a request file an error will be thrown
        $this->requestPath = str_replace('Repositories','Requests',$this->repoPath);
    }

    public function getControllerPath()
    {
        return $this->controllerPath;
    }

    public function validateRequest(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return false;
    }

    public function validateRows($rows)
    {
        $errors = false;

        // validates each row individually
        foreach($rows as $rowId => $inputs) {

            if(empty($inputs)) continue;

            if($inputErrors = $this->validateInputs($inputs)) {
                $errors[$rowId] = $inputErrors;
            }
        }

        return $errors;
    }

    public function validateInputs($inputs, array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make(
            $inputs,
            !empty($rules) ? $rules : $this->getRules(),
            $messages,
            $customAttributes);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return false;
    }

    public function getRules()
    {
        $requestPath = $this->getRequestPath().'Request';
        $requestInstance = new $requestPath;
        $rules = $requestInstance->rules();
        return $rules;
    }

    public function setRequest($requestPath)
    {
        $this->requestPath = $requestPath;
    }

    public function getRequestPath()
    {
        return $this->requestPath;
    }

    public function getParentRepo($relation)
    {
        if(!isset($relation['parentRepo'])) return false;

        return repo()->make($relation['parentRepo']);
    }

    public function getParent($relation)
    {
        if(null === $relation) return false;

        $parentRepo = $this->getParentRepo($relation);
        $parent = $parentRepo->find($relation['parentId']);
        $parent->modelHeading = model_heading($relation['parentRepo']);
        return $parent;
    }

    public function getUserFromToken()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return $user;
    }

}