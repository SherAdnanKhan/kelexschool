<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class resetPasswordRequest extends FormRequest
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
            'password' => [
                'required',
                'string',
                'min:6', 
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'confirm-password' => 'required|same:password'
        ];

    }

    public function messages()
    {
        return[
            'password.required'=>'Password is  required',
            'password.string'=>'Password must be string',
            'password.min'=>'Password can not be less than 6 Characters',
            'password.regex'=>'Password must have a capital letter ,small letter and numbers',
            'confirm-password.required'=>'Confirm-Password is  required',
            'password.same'=>'passwords are not matching',
        ];
    }
}
