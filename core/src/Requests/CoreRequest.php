<?php

namespace Topicmine\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Topicmine\Core\Requests\Traits\CoreRequestMethods;

abstract class CoreRequest extends FormRequest
{
    use CoreRequestMethods;
    
}
