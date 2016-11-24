<?php
namespace Topicmine\UserAccess\Transformers;

use Topicmine\Core\Transformers\RelationTransformer;

class PermissionTransformer extends RelationTransformer {

    public function transform($model)
    {
        return [
            'id'       => $model->id,
            'name'     => $model->name,
            'display_name'    => $model->display_name,
            '__relation:roles' => $this->getRelationship($model, 'roles'),
            '__relation:permission_groups' => $this->getRelationship($model, 'permission_groups'),
            'created_at'    => $model->created_at->toFormattedDateString(),
            'updated_at'    => $model->updated_at->toFormattedDateString(),
        ];
    }
}
