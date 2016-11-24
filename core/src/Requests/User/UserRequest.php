<?php

namespace Topicmine\Core\Requests\User;

use Topicmine\Core\Requests\CoreRequest;

class UserRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'required',
            'email' => 'sometimes|required|email',
        ];

    }

}
