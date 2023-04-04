<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseLectureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:2|max:255',
            'category_id' => 'nullable|integer',
            'start_time' => 'required|date',
            'end_time' => ['required', 'date'],
            'description' => 'required',
            'presentation' => 'max:10240',
            'presentation' => 'nullable|mimes:ppt,pptx|max:10240'
        ];
    }
}
