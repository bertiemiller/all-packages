<?php

namespace Topicmine\Core\Repositories\User;

use Topicmine\Core\Models\User\Role;
use Topicmine\Core\Repositories\CoreRepository;

class RoleRepository extends CoreRepository implements RoleRepositoryInterface{

    public function model()
    {
        return Role::class;
    }

}