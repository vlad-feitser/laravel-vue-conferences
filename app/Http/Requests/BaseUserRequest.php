<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'min:2', 'max:255'],
            'lastname' => ['required', 'string', 'min:2', 'max:255'],
            'type' => ['required'],
            'birthdate' => ['required'],
            'country' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['string', 'min:8'],
        ];
    }
}
