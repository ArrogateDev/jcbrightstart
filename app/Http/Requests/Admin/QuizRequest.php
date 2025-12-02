<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Quiz;
use Illuminate\Validation\Rule;

class QuizRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'title' => 'bail|required|unique:quizzes,title',
            'questions' => 'bail|required|array|min:1',
            'questions.*.title' => 'bail|required',
            'questions.*.options' => 'bail|required|array|min:2',
            'questions.*.correct_answer' => 'bail|required',
        ];

        if ($this->method() === 'PUT') {
            $quiz = $this->route('quiz');
            $id = $quiz instanceof Quiz ? $quiz->id : $quiz;

            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('quizzes')->ignore($id)
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
