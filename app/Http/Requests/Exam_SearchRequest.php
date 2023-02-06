<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Exam_SearchRequest extends FormRequest
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
            'SESSION_ID'=>'required',
            'CLASS_ID'=>'required',
            'SECTION_ID'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'SESSION_ID.required'=> 'A SESSION is required',
            'CLASS_ID.required'=> 'A CLASS is required',
            'SECTION_ID.required'=> 'A SECTION is required',
        ];
    }
}
