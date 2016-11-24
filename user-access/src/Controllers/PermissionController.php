<?php

namespace Topicmine\UserAccess\Controllers;

use Topicmine\DataTables\Controllers\DataTablesController;
use Topicmine\UserAccess\Repositories\PermissionRepositoryInterface;

class PermissionController extends DataTablesController {

    public function __construct(PermissionRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

}
