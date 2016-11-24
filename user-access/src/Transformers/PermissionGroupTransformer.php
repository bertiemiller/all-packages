<?php
namespace Topicmine\UserAccess\Transformers;

use Topicmine\Core\Transformers\RelationTransformer;

class PermissionGroupTransformer extends RelationTransformer {

    public function transform($model)
    {
        return [
            'id'       => $model->id,
            'name'     => $model->name,
            '__relation:roles' => $this->getRelationship($model, 'roles'),
            '__relation:permissions' => $this->getRelationship($model, 'permissions'),
            'created_at'    => $model->created_at->toFormattedDateString(),
            'updated_at'    => $model->updated_at->toFormattedDateString(),
        ];
    }
}
