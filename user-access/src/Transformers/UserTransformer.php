<?php
namespace Topicmine\UserAccess\Transformers;

use Topicmine\Core\Transformers\RelationTransformer;

class UserTransformer extends RelationTransformer {

    public function transform($model)
    {
        return [
            'id'       => $model->id,
            'name'=> $model->name,
            'email'=> $model->email,
            'status'=> $model->status,
            'confirmed'=> $model->confirmed,
            '__relation:roles' => $this->getRelationship($model, 'roles'),
            'created_at'    => $model->created_at->toFormattedDateString(),
            'updated_at'    => $model->updated_at->toFormattedDateString(),
        ];
    }
}
