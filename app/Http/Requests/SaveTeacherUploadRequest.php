<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTeacherUploadRequest extends FormRequest
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
            'SUBJECT_ID'=>'required',

        ];
    }
    public function messages()
    {
        return[
            'SECTION_ID.required' => "Section is required",
            'CLASS_ID.required' => "Class is required",
            'SESSION_ID.required' => "Session is required",
            'SUBJECT_ID.required' => "Subject is required",
        ];
    }
}
