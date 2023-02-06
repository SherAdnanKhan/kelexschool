<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class studentloginRequest extends FormRequest
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
            'REG_NO'=>'required',
            'STD_PASSWORD'=>'required',
        ];
    }

     public function messages()
    {
        return[
       'REG_NO.required' => "Registration Number is required",
        'STD_PASSWORD.required' => "Student Password is required",
    ];
    }
}
