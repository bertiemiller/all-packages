<?php

namespace Topicmine\Content\Controllers\Admin;

use Topicmine\Core\Controllers\CoreController;

class SourcesHomeController extends CoreController
{
    public function index()
    {
        view()->share('title', 'Data Sources Dashboard');
        view()->share('metaDescription', 'Data Sources Dashboard');
        view()->share('h1', 'Data Sources Dashboard');

        return view('admin.panels.content.dashboards.default');
    }
}
