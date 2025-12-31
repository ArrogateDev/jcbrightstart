<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class AdminRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'name' => 'bail|required',
            'account' => 'bail|required',
            'role_id' => 'bail|required',
            'password' => 'bail|required|size:32|confirmed',
            'password_confirmation' => 'bail|required',
            'status' => 'bail|required',
        ];

        if ($this->method() === 'PUT') {
            $rules['password'] = [
                'nullable',
                'bail',
                'size',
                'confirmed',
            ];
            $rules['password_confirmation'] = [
                'nullable',
                'bail'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('姓名不能为空'),
            'account.required' => __('账号不能为空'),
            'role_id.required' => __('角色不能为空'),
            'password.required' => __('密码不能为空'),
            'password.size' => __('密码格式不正确'),
            'password.confirmed' => __('两次密码输入不一致'),
            'password_confirmation.required' => __('确认密码不能为空'),
            'status.required' => __('状态不能为空'),
        ];
    }
}
