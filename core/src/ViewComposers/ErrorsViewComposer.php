<?php

namespace Topicmine\Core\ViewComposers;

use Illuminate\View\View;

class ErrorsViewComposer
{
    public function compose(View $view)
    {
        $view->masterView = 'front.layout.master';
        $view->leftColStatus = 'hide';
        $view->title = 'PAGE NOT FOUND (404 ERROR)!';
        $view->h1 = 'PAGE NOT FOUND (404 ERROR)!';
    }

}
