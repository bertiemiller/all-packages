<?php

namespace Topicmine\Core\Transformers;

use League\Fractal\TransformerAbstract;

class RelationTransformer extends TransformerAbstract
{
    public function getRelationship($model, $relation)
    {
        $model->relationships[$relation]['parentClassName'] = model_heading(get_class($model));

        $model->relationships[$relation]['childPath'] =
            \URL::route($model->relationships[$relation]['childRoute'], [], false);

        $model->relationships[$relation]['title'] = model_heading($model->relationships[$relation]['relationship']);

        $model->relationships[$relation]['actionName'] = 'Select ' ;

        return $model->relationships[$relation];
    }

}
