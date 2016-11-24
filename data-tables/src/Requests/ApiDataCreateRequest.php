<?php

namespace Topicmine\DataTables\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiDataCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
//            '_method' => 'required|in:POST',
        ];
    }
}
