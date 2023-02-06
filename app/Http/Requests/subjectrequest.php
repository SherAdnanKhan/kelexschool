<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class subjectrequest extends FormRequest
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
            'subject_name'=>'required|max:255',
            'subject_code'=>'required',

        ];
    }
    public function messages()
    {
        return [
            'subject_name.required' => 'A subject name is required',
            'max.required' => 'subject name should be less than 255 characters',
            'subject_code.required'  => 'A subject code  is required',
        ];
    }
}
