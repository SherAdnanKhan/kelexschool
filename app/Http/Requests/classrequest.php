<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class classrequest extends FormRequest
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
            'class_name' => 'required|max:255',
        ];
    }
    public function messages()
    {
        return[
            'class_name.required' => "Class Name is required",
            'class_name.max' => "Class Name can not be greater than 255 characters",
        ];
    }
}
