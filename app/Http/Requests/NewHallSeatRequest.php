<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewHallSeatRequest extends FormRequest
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
            'seats' => ['required','array'],
            'seats.*.seat_class_id' => ['required','exists:seat_classes,id'],
            'seats.*.seat_count' => ['integer','required','gte:10','lte:1000'],
            'seats.*.unit_cost' => ['integer','required','gte:50000','lte:1000000']

        ];
    }
}
