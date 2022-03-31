<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewConcertRequest extends FormRequest
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
            'artist_id' => ['required','exists:artists,id'],
            'title' => ['required','min:2','max:50'],
            'description' => ['required','min:10'],
            'starts_at' => ['required','date','before:ends_at'],
            'ends_at' => ['required','date','after:starts_at'],
            'is_published' => ['nullable']
        ];
    }
}
