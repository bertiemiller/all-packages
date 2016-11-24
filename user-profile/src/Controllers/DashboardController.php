<?php

namespace Topicmine\UserProfile\Controllers;

use Topicmine\Core\Controllers\CoreController;

class DashboardController extends CoreController
{
    public function index()
    {
        view()->share('title', 'User Profile Dashboard');
        view()->share('metaDescription', 'User Profile Dashboard');
        view()->share('h1', 'User Profile Dashboard');

        return view('admin.panels.content.dashboards.subsection');
    }
}
