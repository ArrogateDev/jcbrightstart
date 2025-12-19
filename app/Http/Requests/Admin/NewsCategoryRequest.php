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
        ];
    }
}
