<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => [
                'required',
                'string',
                'max:400',
            ],

            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'image' => [
                'nullable',
                'mimes:jpeg,png',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'content.required' => '口コミ内容は必須です。',
            'content.max' => '口コミ内容は最大400文字までです。',
            'rating.required' => '評価は必須です。',
            'rating.between' => '1から5の間で選んでください。',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください。',
        ];
    }
}
