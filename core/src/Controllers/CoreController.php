<?php

namespace Topicmine\Core\Controllers;

use App\Http\Controllers\Controller;
use Topicmine\Core\Controllers\Traits\CoreControllerHelpers;
use Topicmine\Core\Controllers\Traits\CoreControllerMethods;

class CoreController extends Controller
{
    use CoreControllerMethods, CoreControllerHelpers;

    public $account = null;
    public $authUser = null;
    public $accountUser = null;
    public $modelOwner = null;
    public $modelRelation = null;
    public $repo = false;
    public $useStaticView = true;
    public $packageViewFolder = false;
    public $enableJQuery = false;
    public $enableBootstrapJs = false;

}