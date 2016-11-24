<?php

namespace Topicmine\UserAccess\Controllers;

use Topicmine\DataTables\Controllers\DataTablesController;
use Topicmine\UserAccess\Controllers\UserAccessController;
use Topicmine\UserAccess\Repositories\UserRepositoryInterface;

class UserController extends DataTablesController
{
    public $modelOwner = 'App\Account';
    public $modelRelation = 'users';

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }
}
