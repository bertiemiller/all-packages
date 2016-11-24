<?php

namespace Topicmine\Content\Controllers\Admin;

use Topicmine\Core\Controllers\CoreController;

class AnalyticsHomeController extends CoreController
{
    public function index()
    {
        view()->share('title', 'Analytics Dashboard');
        view()->share('metaDescription', 'Analytics Dashboard');
        view()->share('h1', 'Analytics Dashboard');

        return view('admin.panels.content.dashboards.default');
    }
}
