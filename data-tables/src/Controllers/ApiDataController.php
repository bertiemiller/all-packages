<?php

namespace Topicmine\DataTables\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Request as RequestFacade;
use Illuminate\Support\Facades\Input;
use App\Exceptions\GeneralException;
use Topicmine\Core\Criteria\CarbonDateCriteria;
use Topicmine\Core\Criteria\ColumnSearchCriteria;
use Topicmine\Core\Criteria\DateCriteria;
use Topicmine\DataTables\Requests\ApiDataActionRequest;
use Topicmine\DataTables\Requests\ApiDataCreateRequest;
use Topicmine\DataTables\Requests\ApiDataEditRequest;
use Topicmine\DataTables\Requests\ApiDataIndexRequest;
use Topicmine\DataTables\Requests\ApiDataSelectedIdsRequest;
use Topicmine\DataTables\Requests\ApiIndexRequest;
use Topicmine\DataTables\Requests\ApiSearchIndexRequest;

class ApiDataController extends ApiController
{
    public function __construct()
    {
        $this->setRepoPath();

        // check if repo path has been set by controller - avoids failing
        // on system commands
        if($this->repoPath)
        {
            $this->upgradeModelConnection();
            $this->setModelRelationIfExists();
        }
    }

    public function index(ApiDataIndexRequest $request)
    {
        $inputs = $request->all();

        // apply the search fields
        if(isset($inputs['searchFields']) && in_array($inputs['searchFields'], ['updated_at', 'created_at', 'deleted_at'])) {
            $this->repo->pushCriteria(new CarbonDateCriteria($inputs['searchFields'], $inputs['search']));
        }
        elseif(isset($inputs['searchFields'])) {
            $this->repo->pushCriteria(new ColumnSearchCriteria($inputs['searchFields'], $inputs['search']));
        }

        // apply the sort column and direction
        if(isset($inputs['orderBy'])) {
            $this->repo->pushScope($inputs['orderBy']);
        }

        // set pagination limits
        $limit = (isset($inputs['per_page']) ? $inputs['per_page'] : config('repository.pagination.limit', 15));
        $response['per_page'] = $limit;

        // standard pagination
        $paginator = $this->repo->paginate($limit);

        // array of the data and pagination
        $response = $this->repo->getTransformedPagination($paginator);

        // need to pull selected ids from Many to Many table
        $response['selectedIds'] = [];

        // out of paginated items pluck those that are selected - to do
//        $response['selectedIds'] =
//            $this->repo->model
//            ->whereIn('id', $this->repo->model->{$this->relation['relationship']}->pluck('id')->toArray() )
//            ->pluck('id');

        // can remove this when live
        $response['paginator'] = $paginator;
        $response['inputs'] = Input::all();

        return $response;
    }

    // This is work in progress for the top search bar
//    public function search(APISearchIndexRequest $request)
//    {
//        $response['data']['Users'] = $this->searchPaginated('Topicmine\Core\Repositories\User\User', $request);
//
//        return $response;
//    }

    public function create(ApiDataCreateRequest $request)
    {
        $response['inputs'] = $this->repo->getCreateInputs();

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $rows = $request->all();

        if($errors = $this->validateRows($rows)) {
            return response(['errors' => ['messages' =>  $errors]], 400 );
        }

        $ids = $this->repo->storeMultiple($rows);

        if(isset($ids['errors'])) {
            return response(['errors' => ['messages' =>  $ids]], 400 );
        }

        return ajax_flash('Your ' . strtolower($this->modelName) . '(s) have been created.', 'warning')
            ->important()
            ->params(['ids' => $ids]);
    }

    public function edit($id, ApiDataEditRequest $request)
    {
        $data = $this->repo->getItemAndInputs($id);

        return $data;
    }

    public function update($id, Request $request)
    {
        $inputs = $request->all();
        $msg['$inputs'] = $inputs;

        if($errors = $this->validateInputs($inputs, $this->getRules())) {
            return response(['errors' => ['messages' =>  $errors]], 400 );
        }

        $response = $this->repo->update($request->all(), $id);

        if(is_array($response) && in_array('errors', $response)) {
            return response(['errors' => ['messages' =>  $response]], 400 );
        }

        return ajax_flash('Your ' . strtolower($this->modelName) . ' has been updated.', 'info')
            ->important()
            ->params(['response' => $response]);

        return $msg;
    }

    public function destroy($id)
    {
        $response = $this->getRepo()->modelBase->destroy($id);

        return ajax_flash('Your ' . strtolower($this->modelName) . ' has been deleted.', 'info')
            ->important()
            ->params(['response' => $response]);
    }

    public function updateSelected(ApiDataSelectedIdsRequest $request)
    {
        $response = $this->repo->updateSelectedIds($request->all());

        return ajax_flash('Your ' .$this->modelName. 's have been deleted.', 'info')
            ->important()
            ->params(['response' => $response]);
    }

    public function action(ApiDataActionRequest $request)
    {
        $response = $this->repo->action($request->all());

        return ajax_flash('Your action has been successful.', 'warning')
            ->important()
            ->params(['response' => $response]);
    }

    // not sure why i have this - have commented out
//    public function parent()
//    {
//        $parentRepo = $this->getParentRepo($this->relation);
//
//        if(null === $parentRepo) return false;
//
//        $response['results'] = $parentRepo->parentAction();
//        return $response;
//    }

}
