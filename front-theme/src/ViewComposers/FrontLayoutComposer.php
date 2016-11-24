<?php

namespace Topicmine\FrontTheme\ViewComposers;

use Illuminate\View\View;

class FrontLayoutComposer {

    protected $users;

    public function compose(View $view)
    {
        $view->masterView = 'front.layout.master';
        $view->leftColStatus = 'hide';
        $this->setHtmlTags($view);
    }

    public function setHtmlTags(View $view)
    {
        $view->containerTag = 'div';
        $view->subHeading = 'h2';

        $view->containerTagOpen='<'.$view->containerTag.'>';
        $view->containerTagClose='</'.$view->containerTag.'>';
        $view->subHeadingOpen = '<'.$view->subHeading.'>';
        $view->subHeadingClose = '</'.$view->subHeading.'>';
    }
}
