<?php

namespace Topicmine\DataTables\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Topicmine\DataTables\Controllers\Traits\ApiControllerHelper;
use Topicmine\DataTables\Controllers\Traits\ApiControllerMethods;

class ApiController extends Controller
{
    use Helpers;
    use ApiControllerMethods;
    use ApiControllerHelper;
}