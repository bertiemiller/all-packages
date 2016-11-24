<?php

namespace Topicmine\Core\Requests\User;

use Topicmine\Core\Requests\CoreRequest;

class PermissionRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

        ];

    }

}
