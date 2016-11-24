<?php

namespace Topicmine\Core\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class ColumnSearchCriteria implements CriteriaInterface {

    public $searchField;

    public $search;

    public $type;

    public function __construct($searchFields, $search)
    {
        list($searchField, $type) = explode(':', $searchFields);
        $this->searchField = $searchField;
        $this->type = $type;
        $this->search = $search;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where($this->searchField, $this->type, "%".$this->search."%");
        return $model;
    }
}