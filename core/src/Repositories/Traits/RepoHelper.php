<?php

namespace Topicmine\Core\Repositories\Traits;

use DB;
use Carbon\Carbon;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
//use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait RepoHelper {

    public function getTransformedPagination($paginator)
    {
        if (is_subclass_of($paginator, LengthAwarePaginator::class)) {
            $items = $paginator->getCollection();
        } else {
            $items = $paginator;
        }

        if(! count($items) > 0) {
            $response['data'] = [];
            $response['pagination'] = $this->getPagination($paginator);
            return $response;
        }

        $response['criteria'] = $this->getCriteria();
        $manager = new Manager();
        $transformer = $this->transformer();
        $resource = new Collection($items, new $transformer());
        $response['data'] = $manager->createData($resource)->toArray()['data'] ;
        $response['pagination'] = $this->getPagination($paginator);

        return $response;
    }

    public function getPagination($paginator)
    {
        if (is_subclass_of($paginator, LengthAwarePaginator::class)) {
            return [

                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                "next_page_url" => $paginator->nextPageUrl(),
                "prev_page_url" => $paginator->previousPageUrl(),
            ];
        } else {
            return [

                'total' => 0,
                'per_page' => 0,
                'current_page' => 1,
                'last_page' => 1,
                'from' => 1,
                'to' => 1,
                "next_page_url" => null,
                "prev_page_url" => null,
            ];
        }

    }

    public function setModelWithRelation($parentRepo, $relation, $parentId = null)
    {
        $parentModel = repo()->make($parentRepo)->model();

        if(! $parentId) {
            switch ($parentModel) {
                case 'App\User':
                    $parentId = auth_user()->id;
                    break;
                case 'App\Account':
                    $parentId  = account()->id;
                    break;
                default:
                    throw new GeneralException('Cannot determnine owner model for Repository: ' . $parentModel);
                    break;
            }
        }

        // Something has gone wrong
        if(! $parentId) {
            throw new GeneralException('Cannot determnine owner model for Repository.');
            return false;
        }

        // Set parent relationship into model
        $model = $this->app->make($parentModel)
            ->find($parentId)
            ->{$relation}();

        return $this->model = $model;
    }

    public function pushScope($orderBy)
    {
        if(!empty($orderBy) && contains($orderBy, '|'))
        {
            list($column, $direction) = explode('|', $orderBy);

            if (!in_array('name', $this->modelBase->getFillable()) and count($this->modelBase->getFillable()) > 0)
            {
                $column = $this->modelBase->getFillable()[0];
            }

            $this->scopeQuery(function ($query) use ($column, $direction)
            {
                return $query->orderBy($column, $direction);
            });
        }
    }

    public function getItemAndInputs($id)
    {
        $data['item'] = $this->find($id);
        $data['inputs'] = $this->getEditInputs($data['item']);
        return $data;
    }
    
    public function selectedIdsExist($inputs)
    {
        if (isset($inputs['selectedIds']))
        {
            return true;
        }
        
        return false;
    }
    
    public function findParentMatches($namespaceRoute)
    {
        $subject = request()->url();
        $pattern = '/^.*\/'.$namespaceRoute.'\/(\w+)\/(\d+)\/.*/i';
        preg_match($pattern, $subject, $matches);

        if(empty($matches)) {
            return false;
        }

        $matches[2] = intval($matches[2]);

        return $matches;
    }
    
    public function convertArrayToInputs($array)
    {
        $inputs = [];

        foreach($array as $name=>$row) {

            if(! is_array($row) || empty($row)) continue;

            foreach($row as $i=>$value) {

                if(empty($value)) continue;

                $inputs[$i][$name] = $value;
            }
        }

        return $inputs;
    }

    public function addAdditionalAttributes($inputs, $additionalAttributes = [])
    {
        foreach ($inputs as $k => $item)
        {
            if(empty($item)) unset($inputs[$k]);

            if (!empty($additionalAttributes))
            {

                foreach ($additionalAttributes as $attrName => $attrValue)
                {

                    $inputs[$k][$attrName] = $attrValue;
                }
            }

            $item['account_id'] = account()->id;
            $item['user_id'] = auth_user()->id;

            $inputs[$k] = $this->getAllowedInputs($this->modelBase->getFillable(), $item);

            $inputs[$k]['updated_at'] = Carbon::now();
            $inputs[$k]['created_at'] = Carbon::now();
        }

        return $inputs;
    }

    // This is old version, keeping for reference for now
//    public function addAdditionalAttributes($inputs, $additionalAttributes = [])
//    {
//        foreach($inputs as $k=>$item) {
//
//            if(! empty($additionalAttributes)) {
//
//                foreach($additionalAttributes as $attrName=>$attrValue) {
//
//                    $inputs[$k][$attrName] = $attrValue;
//                }
//            }
//
//            $inputs[$k] = $this->getAllowedCreateArrayInputs( $this->getEditFields(), $item);
//
//            $inputs[$k]['account_id'] = auth_user()->account_id;
//            $inputs[$k]['user_id'] = auth_user()->id;
//            $inputs[$k] = $this->getAllowedCreateArrayInputs( $this->modelBase->getFillable(), $item);
//
//            $inputs[$k]['updated_at'] = Carbon::now();
//            $inputs[$k]['created_at'] = Carbon::now();
//        }
//
//        return $inputs;
//    }

    public static function getTableName($model)
    {
        return DB::getTablePrefix() . $model->getTable();
    }

    public function getAllowedInputs($allowed, $inputs)
    {
        $flipped_haystack = array_flip($allowed);
        foreach ($inputs as $key => $value)
        {
            if (!isset($flipped_haystack[$key]))
            {
                unset($inputs[$key]);
            }
        }

        return $inputs;
    }

}