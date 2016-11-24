<?php

namespace Topicmine\Core\Repositories\User;

use Topicmine\Core\Models\User\PermissionGroup;
use Topicmine\Core\Repositories\CoreRepository;

class PermissionGroupRepository extends CoreRepository implements PermissionGroupRepositoryInterface{

    public function model()
    {
        return PermissionGroup::class;
    }

}