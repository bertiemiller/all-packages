<?php

namespace Topicmine\DataTables\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiDataSelectedIdsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'action' => 'required|in:delete',
            'selectedIds' => 'sometimes|array',
            'uncheckedSelectedIds' => 'sometimes|array',
        ];
    }

    public function messages()
    {
        return [
            'selectedIds.required' => 'The values must contain one array',
            'selectedIds.array' => 'The values must contain one array2',
        ];
    }
}
