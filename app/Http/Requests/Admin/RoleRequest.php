<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'name' => 'bail|required|unique:roles,name',
            'node' => 'bail|nullable|array',
        ];

        if ($this->method() === 'PUT') {
            $id = $this->segment(3);
            $rules['name'] = [
                'nullable',
                'bail',
                Rule::unique('roles')->ignore($id)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '请输入角色名称',
            'name.unique' => '角色名称已经存在',
            'status.required' => '状态格式错误',
            'status.in' => '状态格式错误',
            'menus.array' => '权限格式错误'
        ];
    }
}
