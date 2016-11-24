<?php

namespace Topicmine\UserAccess\Repositories;

use Topicmine\Core\Repositories\User\RoleRepository as RoleRepo;
use Topicmine\UserAccess\Repositories\RoleRepositoryInterface;
use Topicmine\UserAccess\Transformers\RoleTransformer;

class RoleRepository extends RoleRepo implements RoleRepositoryInterface{

    public function transformer()
    {
        return RoleTransformer::class;
    }
}
