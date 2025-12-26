<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\News;
use Illuminate\Validation\Rule;

class NewsRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'title' => 'bail|required',
            'category_id' => 'bail|required|exists:news_categories,id',
            'thumbnail' => 'bail|required|image',
            'short' => 'bail|required',
            'start_date' => 'bail|required|date:Y-m-d',
            'end_date' => 'bail|required|date:Y-m-d|after_or_equal:start_date',
            'start_time' => 'bail|required|date:H:i A',
            'end_time' => 'bail|required|date:H:i A|after_or_equal:start_time',
            'description' => 'bail|required',
            'status' => 'bail|required|in:0,1,2',
        ];

        if ($this->method() === 'PUT') {
            $news = $this->route('news');
            $rules['thumbnail'] = 'bail|nullable|image';
            $id = $news instanceof News ? $news->id : $news;
            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('news')->ignore($id)
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
