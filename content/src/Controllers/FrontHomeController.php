<?php

namespace Topicmine\Content\Controllers;

use App\Http\Controllers\Controller;

class FrontHomeController extends Controller
{
    public function index()
    {
        return view('front.index');
    }

}
