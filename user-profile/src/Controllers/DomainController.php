<?php

namespace Topicmine\UserProfile\Controllers;

use Topicmine\Core\Repositories\Account\DomainRepositoryInterface;
use Topicmine\DataTables\Controllers\DataTablesController;

class DomainController extends DataTablesController
{
    public function __construct(DomainRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

}
