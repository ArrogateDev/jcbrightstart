<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\BaseRequest;

class MessageRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'name' => 'bail|required',
            'email' => 'bail|required|email',
            'message' => 'bail|required'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('名字不能为空'),
            'email.required' => __('邮箱不能为空'),
            'email.email' => __('邮箱格式不正确'),
            'message.required' => __('留言不能为空'),
        ];
    }
}
