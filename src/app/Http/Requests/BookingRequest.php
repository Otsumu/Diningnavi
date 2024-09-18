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
            'shop_id' => 'required|exists:shops,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
            'number' => 'required|integer|min:1',
        ];
    }

    public function messages() {
        return [
            'booking_date.required' => '予約日時を入力してください',
            'booking_time.required' => '予約時間を入力してください',
            'number.required' => '人数を入力してください',
            'number.integer' => '人数を正しく指定してください',
            'number.min' => '人数は1以上で指定してください',
        ];
    }

}
