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
            'gender' => 'bail|required|in:0,1',
            'age' => 'bail|required|in:0,1,2,3,4,5,6',
        ];

        return $rules;
    }
}
