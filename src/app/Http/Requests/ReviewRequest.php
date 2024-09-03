<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'booking_id' => 'required|exists:bookings,id',
            'title' => 'nullable|string|max:20',
            'review' => 'required|string|max:400',
            'rating' => 'required|integer|between:1,5',
        ];
    }

    public function messages() {
        return [
            'booking_id' => '予約IDを入力してください',
            'review.required' => '400字以内で入力してください',
            'rating.required' => '評価をお願いします',
            'rating.between' => '評価は1から5の範囲で入力してください',
        ];
    }
}
