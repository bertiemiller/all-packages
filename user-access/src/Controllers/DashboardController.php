<?php

namespace Topicmine\UserAccess\Controllers;

use Topicmine\Core\Controllers\CoreController;

class DashboardController extends CoreController
{
    public function index()
    {
        view()->share('title', 'User Access Dashboard');
        view()->share('metaDescription', 'User Access Dashboard');
        view()->share('h1', 'User Access Dashboard');

        return view('admin.panels.content.dashboards.subsection');
    }
}
