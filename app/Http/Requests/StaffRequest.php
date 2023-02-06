<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'username'=>'required|max:255',
            'password'=>'required|max:255',
            'email'=>'required',
        ];
    }
    public function messages()
    {

        return [

            'username.required' => "Staff Name is required",
            'username.max' => "Staff Name can not be greater than 255 characters",
  
            'password.required' => "Password  is required",
            'password.max' => "Password can not be greater than 255 characters",

            'email.required' => "Email is required",
          
        ];

    }
}
