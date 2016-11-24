<?php

namespace Topicmine\Core\Controllers;

use App\Http\Controllers\Controller;

class FrontHomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

}
