<?php

namespace Topicmine\UserAccess\Repositories;

use Topicmine\UserAccess\Transformers\PermissionGroupTransformer;
use Topicmine\Core\Repositories\User\PermissionGroupRepository as PermissionGroupRepositoryBase;

class PermissionGroupRepository extends PermissionGroupRepositoryBase implements PermissionGroupRepositoryInterface{

    public function transformer()
    {
        return PermissionGroupTransformer::class;
    }
}