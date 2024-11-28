<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportShopRequest extends FormRequest
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
            'csv_file' => 'required|file|mimes:csv,txt',
        ];
    }

    public function messages()
    {
        return [
            'csv_file.required' => 'CSVファイルを選択してください。',
            'csv_file.mimes' => 'CSV形式のファイルをアップロードしてください。',
        ];
    }

    public static function rowRules()
    {
        return [
            '店舗名' => 'required|string|max:50',
            '地域' => 'required|in:東京都,大阪府,福岡県',
            'ジャンル' => 'required|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
            '店舗概要' => 'required|string|max:400',
            '画像URL' => 'required|file|mimes:jpeg,png',
        ];
    }

    public static function rowMessages()
    {
        return [
            '店舗名.required' => '店舗名は必須です',
            '地域.in' => '地域は「東京都」「大阪府」「福岡県」のいずれかを指定してください',
            'ジャンル.in' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを指定してください',
            '店舗概要.max' => '店舗概要は400文字以内で入力してください',
            '画像URL.mimes' => '画像URLはjpegまたはpng形式のみ対応しています',
        ];
    }
}
