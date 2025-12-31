<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\NewsCategory;
use Illuminate\Validation\Rule;

class NewsCategoryRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'title' => 'bail|required|unique:news_categories,title',
            'is_nav' => 'bail|required|in:0,1',
            'status' => 'bail|required|in:0,1'
        ];

        if ($this->method() == 'PUT') {
            $category = $this->route('category');
            $id = $category instanceof NewsCategory ? $category->id : $category;

            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('news_categories')->ignore($id)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => __('标题不能为空'),
            'title.unique' => __('标题已经存在'),
            'is_nav.required' => __('导航显示不能为空'),
            'is_nav.in' => __('导航显示格式错误'),
            'status.required' => __('状态不能为空'),
            'status.in' => __('状态格式错误'),
        ];
    }
}
