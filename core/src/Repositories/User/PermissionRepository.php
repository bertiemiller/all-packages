<?php

namespace Topicmine\Core\Repositories\User;

use Topicmine\Core\Models\User\Permission;
use Topicmine\Core\Repositories\CoreRepository;

class PermissionRepository extends CoreRepository implements PermissionRepositoryInterface{
    
    public function model()
    {
        return Permission::class;
    }

}