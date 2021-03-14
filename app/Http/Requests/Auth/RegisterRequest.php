<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            
            'name' => ['required'],

            'username' => ['alpha_num', 'required', 'min:3', 'unique:users,username'],

            'email' => ['email', 'required', 'unique:users,email'],

            'password' => [ 'required', 'min:6'],

            'telephone' => ['required', 'unique:users,telephone'],

            'role' => ['required', 'string'],

            'faculty' => ['string'],

            'department' => ['string'],

            'batch' => ['integer']
        ];
    }
}
