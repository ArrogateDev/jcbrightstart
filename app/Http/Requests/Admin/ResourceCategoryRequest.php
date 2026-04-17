<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Resource\ResourceCategory;
use Illuminate\Validation\Rule;

class ResourceCategoryRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'title' => 'bail|required|unique:resource_categories,title,null,deleted_at',
            'pid' => 'bail|exclude_if:pid,0|exists:resource_categories,id',
            'status' => 'bail|required|in:0,1'
        ];

        if ($this->method() == 'PUT') {
            $category = $this->route('category');
            $id = $category instanceof ResourceCategory ? $category->id : $category;

            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('resource_categories')->ignore($id)->where('deleted_at', null)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => __('标题不能为空'),
            'title.unique' => __('标题已经存在'),
            'pid.exclude_if' => __('父级格式错误'),
            'pid.exists' => __('父级格式错误'),
            'status.required' => __('状态不能为空'),
            'status.in' => __('状态格式错误'),
        ];
    }
}
