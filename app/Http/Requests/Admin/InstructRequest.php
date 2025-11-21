<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class InstructRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'instruct' => 'bail|required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'instruct.required' => __('请输入姓名'),
        ];
    }
}
