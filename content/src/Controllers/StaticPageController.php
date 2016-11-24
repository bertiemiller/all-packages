<?php

namespace Topicmine\Content\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    public function show(Request $request)
    {
        $slug = $request->path();

        return view('front.statics.'.$slug);
    }
}
