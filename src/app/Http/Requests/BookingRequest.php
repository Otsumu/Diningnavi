<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'booking_date' => 'required|datetime',
            'number' => 'required|integer|min:1',
        ];
    }

    public function messages() {
        return [
            'user_id.required' => 'IDを入力してください',
            'user_id.exists' => '指定のユーザーは存在しません',
            'shop_id.required' => 'お店を指定してください',
            'shop_id.exists' => '指定のお店が見つかりません',
            'booking_date.required' => '予約日時を入力してください',
            'booking_date.datetime' => '予約日時は有効な形式で指定してください',
            'number.required' => '人数を入力してください',
            'number.integer' => '人数を正しく指定してください',
            'number.min' => '人数は1以上で指定してください',
        ];
    }

}
