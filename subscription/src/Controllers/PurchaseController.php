<?php

namespace Topicmine\Subscription\Controllers;

use Topicmine\DataTables\Controllers\DataTablesController;
use Topicmine\Subscription\Repositories\PurchaseRepositoryInterface;

class PurchaseController extends DataTablesController
{
    public function __construct(PurchaseRepositoryInterface $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

    public function printInvoice($id)
    {
        return $this->repo->printInvoice($id);
    }
    
}