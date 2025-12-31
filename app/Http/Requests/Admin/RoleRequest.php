<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Manage\Role;
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
            $role = $this->route('role');
            $id = $role instanceof Role ? $role->id : $role;

            $rules['name'] = [
                'bail',
                'required',
                Rule::unique('roles')->ignore($id)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('角色名称不能为空'),
            'name.unique' => __('角色名称已经存在'),
            'node.array' => __('权限节点必须是数组'),
        ];
    }
}
