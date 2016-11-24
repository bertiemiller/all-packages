<?php

namespace Topicmine\Core\Requests\Account;

use Topicmine\Core\Requests\CoreRequest;

class DomainRequest extends CoreRequest
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