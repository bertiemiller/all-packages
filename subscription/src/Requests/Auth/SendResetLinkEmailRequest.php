<?php

namespace Topicmine\Subscription\Requests\Auth;
use Topicmine\Core\Requests\CoreRequest;


/**
 * Class SendResetLinkEmailRequest
 * @package App\Http\Requests\Front\Access
 */
class SendResetLinkEmailRequest extends CoreRequest
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
            'email' => 'required|email',
        ];
    }
}
