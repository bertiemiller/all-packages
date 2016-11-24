<?php

namespace Topicmine\UserAccess\Repositories;

use Topicmine\Core\Repositories\User\UserRepository as UserRepo;
use Topicmine\UserAccess\Repositories\UserRepositoryInterface;
use Topicmine\UserAccess\Transformers\UserTransformer;

class UserRepository extends UserRepo implements UserRepositoryInterface{

    public function transformer()
    {
        return UserTransformer::class;
    }

}