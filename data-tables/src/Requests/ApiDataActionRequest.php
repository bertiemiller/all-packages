<?php

namespace Topicmine\DataTables\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiDataActionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'action' => 'required',
        ];
    }

}
