<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class paper_uploadRequest extends FormRequest
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
            'SECTION_ID'=> 'required',
            'CLASS_ID'=>'required',
            'SESSION_ID'=>'required',
            'EXAM_ID'=>'required',
            'SUBJECT_ID'=>'required',
            "EMP_ID"    => "required|array|min:1",
            "EMP_ID.*"  => "required|string|min:1",
            'DUEDATE'=>'required',

        ];
    }
    public function messages()
    {
        return[
            'SECTION_ID.required' => "Section is required",
            'CLASS_ID.required' => "Class is required",
            'SESSION_ID.required' => "Session is required",
            'EXAM_ID.required' => "Exam is required",
            'SUBJECT_ID.required' => "Exam is required",
            'DUEDATE.required' => "DUEDATE is required",
            
        ];
    }
}
