<?php

namespace Topicmine\Core\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class OrderByCriteria implements CriteriaInterface {

    public $column = false;

    public $direction = false;

    public function __construct($fillable, $orderBy)
    {
        if(!empty($orderBy) && contains($orderBy, '|'))
        {
            list($this->column, $this->direction) = explode('|', $orderBy);
        }

        if(! in_array('name', $fillable) and count($fillable) > 0) {
            $this->column = $fillable[0];
        }
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->orderBy($this->column, $this->direction);

        return $model;
    }
}