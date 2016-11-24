<?php

namespace Topicmine\Core\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    public function transform($model)
    {
        return $model->toArray();
    }
}
