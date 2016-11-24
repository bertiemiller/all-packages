<?php

namespace Topicmine\UrlScrape\Controllers;

use Topicmine\Core\Controllers\CoreController;

class DashboardController extends CoreController
{
    public function index()
    {
        view()->share('title', 'Url Scrapes Dashboard');
        view()->share('metaDescription', 'Url Scrapes Dashboard');
        view()->share('h1', 'Url Scrapes Dashboard');

        return view('admin.panels.content.dashboards.subsection');
    }
}
