<?php

namespace Topicmine\Subscription\Requests;

use Topicmine\Core\Requests\CoreRequest;

class SubscriptionRequest extends CoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topics' => 'required|numeric',
            'domains' => 'required|numeric',
        ];

    }
}
