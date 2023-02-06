<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Kelex_grades extends FormRequest
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
           'GRADE_NAME'=>'required|max:255',
            'FROM_MARKS'=>'required',
            'TO_MARKS' =>'required',
        ];
    }

     public function messages()
    {
        return[
            'GRADE_NAME.required' => "Grade Name is required",
            'GRADE_NAME.max' => "Grade Name can't be greater than 255 characters",
            'FROM_MARKS.required' => "Starting MARKS range is required",
            'TO_MARKS.required' => "Ending MARKS range is required",
    ];
    }
}
