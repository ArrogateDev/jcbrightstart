<?php

namespace App\Http\Requests;

class ChangePasswordRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'current_password' => 'bail|required|size:32',
            'password' => 'bail|required|size:32|confirmed',
            'password_confirmation' => 'bail|required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'current_password.required' => __('当前密码不能为空'),
            'current_password.size' => __('当前密码格式不正确'),
            'password.required' => __('新密码不能为空'),
            'password.size' => __('新密码格式不正确'),
            'password.confirmed' => __('两次密码输入不一致'),
            'password_confirmation.required' => __('确认密码不能为空'),
        ];
    }
}
