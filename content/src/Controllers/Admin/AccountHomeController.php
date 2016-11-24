<?php

namespace Topicmine\Content\Controllers\Admin;

use Topicmine\Core\Controllers\CoreController;

class AccountHomeController extends CoreController
{
    public function index()
    {
        view()->share('title', 'Account Dashboard');
        view()->share('metaDescription', 'Account Dashboard');
        view()->share('h1', 'Account Dashboard');

        return view('admin.panels.dashboard');
    }
}
