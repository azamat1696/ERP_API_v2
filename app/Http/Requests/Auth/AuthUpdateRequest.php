<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthUpdateRequest extends FormRequest
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
            'oldPassword' => 'required',
            'password' => 'min:4|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:4'
              
        ];
    }
}
