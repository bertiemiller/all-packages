<?php

namespace Topicmine\Core\Requests\User;

use Topicmine\Core\Requests\CoreRequest;

class PermissionGroupRequest extends CoreRequest
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
