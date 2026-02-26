<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\BaseRequest;

class VerificationCodeRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'email' => 'bail|required|email',
            'scene' => 'bail|required|in:register,bind',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => __('邮箱不能为空'),
            'email.email' => __('邮箱格式不正确'),
            'scene.required' => __('场景不能为空'),
            'scene.in' => __('场景格式错误'),
        ];
    }
}
