<?php

namespace App\Http\Requests\Web\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'first_name' => 'bail|required',
            'last_name' => 'bail|required',
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('users')->withoutTrashed()
            ],
            'password' => 'bail|required|size:32|confirmed',
            'password_confirmation' => 'bail|required',
            'agree' => 'bail|accepted',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => __('名字不能为空'),
            'last_name.required' => __('姓氏不能为空'),
            'email.required' => __('邮箱不能为空'),
            'email.email' => __('邮箱格式不正确'),
            'email.unique' => __('邮箱已经被注册'),
            'password.required' => __('密码不能为空'),
            'password.size' => __('密码格式不正确'),
            'password.confirmed' => __('两次密码输入不一致'),
            'password_confirmation.required' => __('确认密码不能为空'),
            'agree.accepted' => __('必须同意服务条款'),
        ];
    }
}
