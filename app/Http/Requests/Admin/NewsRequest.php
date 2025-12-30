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
            'status' => 'bail|required|in:0,1'
        ];

        $status = $this->input('status');
        if ($status == News::STATUS_PUBLISHED) {
            $rules['title'] = 'bail|required';
            $rules['category_id'] = 'bail|required|exists:news_categories,id';
            $rules['short'] = 'bail|required';
            $rules['start_date'] = 'bail|required|date:Y-m-d';
            $rules['end_date'] = 'bail|required|date:Y-m-d|after_or_equal:start_date';
            $rules['start_time'] = 'bail|required|date:H:i A';
            $rules['end_time'] = 'bail|required|date:H:i A|after_or_equal:start_time';
            $rules['description'] = 'bail|required';
        }

        if ($status == News::STATUS_PUBLISHED && $this->method() === 'PUT') {
            $news = $this->route('news');
            $rules['thumbnail'] = 'bail|required_without:thumbnail_url|image';
            $rules['thumbnail_url'] = 'bail|required_without:thumbnail|file_exists';
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
