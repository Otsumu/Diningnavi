<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
    public function rules() {
        return [
            'name' => 'required|string|max:191',
            'image_url' => 'nullable|url|max:191',
            'intro' => 'nullable|string|max:500',
            'genre_id' => 'required|exists:genres,id',
            'area_id' => 'required|exists:areas,id',
        ];
    }

    public function messages() {
        return [
            'name.required' => '店名を入力してください',
            'image_url.url' => '有効なURLを入力してください',
            'image_url.max' => 'URLは255文字以内で入力してください',
            'intro.string' => '紹介文は文字列で入力してください',
            'intro.max' => '紹介文は500文字以内で入力してください',
            'genre_id.required' => 'ジャンルを入力してください',
            'genre_id.exists' => '選択したジャンルが無効です',
            'area_id.required' => 'エリアを入力してください',
            'area_id.exists' => '選択したエリアが無効です',
        ];
    }
}
