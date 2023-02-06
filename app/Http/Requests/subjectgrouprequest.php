<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class subjectgrouprequest extends FormRequest
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
            'GROUP_ID'=>'required',
            'CLASS_ID'=>'required',
            'SECTION_ID' =>'required',
            'SESSION_ID' =>'required',
        ];
    }
    public function messages()
    {
        return [
            'GROUP_ID.required' => 'A Subject Group Name is required',
            'CLASS_ID.required'  => 'A CLASS is required',
            'SECTION_ID.required' => 'A SECTION is required',
            'SESSION_ID.required'  => 'A SESSION is required',
        ];
    }
}
