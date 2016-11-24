<?php

namespace Topicmine\Content\Controllers\Admin;

use Topicmine\Core\Controllers\CoreController;

class AdminHomeController extends CoreController
{
    public function index()
    {
        view()->share('title', 'Admin Dashboard');
        view()->share('metaDescription', 'Admin Dashboard');
        view()->share('h1', 'Admin Dashboard');

        return view('admin.panels.dashboard');
    }
}
