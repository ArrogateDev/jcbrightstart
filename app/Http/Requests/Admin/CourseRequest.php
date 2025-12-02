<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Quiz;
use Illuminate\Validation\Rule;

class CourseRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'status' => 'bail|required|in:0,1,2',
        ];

        $status = $this->input('status');
        if ($status == 2) {
            $rules['title'] = 'bail|required|unique:courses';
            $rules['thumbnail'] = 'bail|required|image';
            $rules['video_url'] = 'bail|required|url';
            $rules['category_id'] = 'bail|required';
            $rules['level'] = 'bail|required';
            $rules['language'] = 'bail|required';
            $rules['short'] = 'bail|required';
            $rules['description'] = 'bail|required';
        }

        if ($this->method() === 'PUT') {
            $course = $this->route('course');
            $id = $course instanceof Quiz ? $course->id : $course;

            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('courses')->ignore($id)
            ];
            $rules['image'] = 'bail|nullable|image';
        }

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
