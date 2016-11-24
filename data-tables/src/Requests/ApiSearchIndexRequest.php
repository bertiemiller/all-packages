<?php

namespace Topicmine\DataTables\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiSearchIndexRequest extends FormRequest
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
