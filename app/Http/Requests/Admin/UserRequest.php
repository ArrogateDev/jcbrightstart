<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'email' => 'bail|required',
            'first_name' => 'bail|required',
            'last_name' => 'bail|required',
            'gender' => 'bail|required',
            'status' => 'bail|required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => __('邮箱不能为空'),
            'first_name.required' => __('名字不能为空'),
            'last_name.required' => __('姓氏不能为空'),
            'gender.required' => __('性别不能为空'),
            'status.required' => __('状态不能为空'),
        ];
    }
}
