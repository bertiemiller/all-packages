<?php

namespace Topicmine\Content\Controllers\Admin;

use Topicmine\Core\Controllers\CoreController;

class ModelsHomeController extends CoreController
{
    public function index()
    {
        view()->share('title', 'Models Dashboard');
        view()->share('metaDescription', 'Models Dashboard');
        view()->share('h1', 'Models Dashboard');

        return view('admin.panels.content.dashboards.default');
    }
}
