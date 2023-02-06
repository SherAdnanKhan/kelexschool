<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Kelex_exams extends FormRequest
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
           'EXAM_NAME'=>'required|max:255',
            'START_DATE'=>'required',
            'END_DATE' =>'required',
            'SESSION_ID'=>'required',
        ];
    }

     public function messages()
    {
        return[
            'EXAM_NAME.required' => "Session Batches Name is required",
            'EXAM_NAME.max' => "Examination Name can't be greater than 255 characters",
            'START_DATE.required' => "Start Date is required",
            'END_DATE.required' => "End Date is required",
            'SESSION_ID.required' => "Session id Field is required",
    ];
    }
}
