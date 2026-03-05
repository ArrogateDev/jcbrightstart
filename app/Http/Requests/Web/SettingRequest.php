<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\BaseRequest;

class SettingRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'first_name' => 'bail|required',
            'last_name' => 'bail|required',
            'gender' => 'bail|required|in:0,1,2',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => __('名字不能为空'),
            'last_name.required' => __('姓氏不能为空'),
            'gender.required' => __('性别不能为空'),
            'gender.in' => __('性别格式错误'),
            'age.required' => __('年龄不能为空'),
            'age.in' => __('年龄格式错误'),
        ];
    }
}
