<?php
namespace Topicmine\UserAccess\Transformers;

use Topicmine\Core\Transformers\RelationTransformer;

class RoleTransformer extends RelationTransformer {

    public function transform($model)
    {
        return [
            'id'       => $model->id,
            'name'     => $model->name,
            'default'    => $model->default,
            'editable'    => $model->editable,
            '__relation:permissions' => $this->getRelationship($model, 'permissions'),
            '__relation:permission_groups' => $this->getRelationship($model, 'permission_groups'),
            'created_at'    => $model->created_at->toFormattedDateString(),
            'updated_at'    => $model->updated_at->toFormattedDateString(),
        ];
    }
}
