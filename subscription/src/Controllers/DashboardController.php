<?php

namespace Topicmine\Subscription\Controllers;

use View;
use Topicmine\Core\Controllers\CoreController;

class DashboardController extends CoreController
{
    public function index()
    {
        view()->share('title', 'Subscriptions Dashboard');
        view()->share('metaDescription', 'Subscriptions Dashboard');
        view()->share('h1', 'Subscriptions Dashboard');

        return view('admin.panels.content.dashboards.subsection');
    }
}
