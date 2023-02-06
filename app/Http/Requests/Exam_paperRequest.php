<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Exam_paperRequest extends FormRequest
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
                 'EXAM_ID'=>'required',
                 'SECTION_ID'=>'required',
                 'SUBJECT_ID' =>'required',
                 'CLASS_ID'=>'required',
                 'TIME'=>'required|max:255',
                 'DATE'=>'required',
                 'TOTAL_MARKS' =>'required',
                 'PASSING_MARKS'=>'required',
                  'VIVA'=>'required|max:255',
                // 'VIVA_MARKS'=>'required',
                 'SESSION_ID'=>'required',
        ];
    }
}
