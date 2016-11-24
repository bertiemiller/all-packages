<?php
namespace Topicmine\Core\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

    public function transform($model)
    {
        return [
            'id'       => $model->id,
            'name'=> $model->name,
            'email'=> $model->email,
            'status'=> $model->status,
            'confirmed'=> $model->confirmed,
            'created_at'    => $model->created_at->toFormattedDateString(),
            'updated_at'    => $model->updated_at->toFormattedDateString(),
        ];
    }
}
