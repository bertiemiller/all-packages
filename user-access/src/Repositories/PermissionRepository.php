<?php

namespace Topicmine\UserAccess\Repositories;

use Topicmine\UserAccess\Transformers\PermissionTransformer;
use Topicmine\Core\Repositories\User\PermissionRepository as PermissionRepositoryBase;

class PermissionRepository extends PermissionRepositoryBase implements PermissionRepositoryInterface{

    public function transformer()
    {
        return PermissionTransformer::class;
    }
}
