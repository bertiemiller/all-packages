<?php

namespace Topicmine\UserAccess\Controllers;

use App\Http\Controllers\AdminController;
use Topicmine\DataTables\Controllers\DataTablesController;
use Topicmine\UserAccess\Repositories\RoleRepositoryInterface;

class RoleController extends DataTablesController
{
    public function __construct(RoleRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }
    
}
