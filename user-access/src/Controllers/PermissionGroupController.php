<?php

namespace Topicmine\UserAccess\Controllers;

use Topicmine\DataTables\Controllers\DataTablesController;
use Topicmine\UserAccess\Repositories\PermissionGroupRepositoryInterface;

class PermissionGroupController extends DataTablesController
{
    public function __construct(PermissionGroupRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }
}
