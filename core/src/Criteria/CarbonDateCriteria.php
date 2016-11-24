<?php

namespace Topicmine\Core\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class CarbonDateCriteria implements CriteriaInterface {

    public $dateField;

    public $search;

    public $type;

    public function __construct($searchFields, $search)
    {
        list($dateField, $type) = explode(':', $searchFields);

        $this->dateField = $dateField;
        $this->search = $search;
        $this->type = $type;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereRaw("DATE_FORMAT(".$this->dateField.", '%b %e, %Y') ".$this->type." '%".$this->search."%'");
        return $model;
    }
}