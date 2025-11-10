<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class GeminiRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'file' => 'bail|required|image',
            'model' => 'bail|required|in:0,1',
            'environment' => 'bail|required|in:0,1,2',
            'tts' => 'bail|required|in:0,1',
            'lang' => 'bail|required_if:tts,0|in:0,1',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'file.required' => '請上傳圖片',
            'file.image' => '圖片格式錯誤',
            'model.required' => '模式格式錯誤',
            'model.in' => '模式格式錯誤',
            'environment.required' => '環境格式錯誤',
            'environment.in' => '環境格式錯誤',
            'tts.required' => '語音格式錯誤',
            'tts.in' => '語音格式錯誤',
            'lang.required' => '語言格式錯誤',
            'lang.in' => '語言格式錯誤',
        ];
    }
}
