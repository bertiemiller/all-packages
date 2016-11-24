<?php

namespace Topicmine\DataTables\Controllers;

use Topicmine\Core\Controllers\CoreController;

/*
 * This controller is extended by other packages that use datatables
 */

class DataTablesController extends CoreController
{
    public $packageViewFolder = 'admin.panels.datatables';
    public $enableJQuery = true;
    public $useStaticView = false;

    public function __construct()
    {
        parent::__construct();
    }
}
