<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class studentrequest extends FormRequest
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
            'NAME'=>'required|max:255',
            'FATHER_NAME'=>'required|max:255',
            // 'PRESENT_ADDRESS'=>'required',
            // 'PERMANENT_ADDRESS' =>'required',
            'GUARDIAN'=>'required',
            // 'SLC_NO'=>'required',
            // 'PASSING_YEAR'=>'required',
            'IMAGE'=>'mimes:jpeg,jpg,png,gif,jfif,JFIF|max:10000',
            'SESSION_ID'=>'required',
            'CLASS_ID'=>'required',
            'SECTION_ID'=>'required',
        ];
    }
    public function messages()
{
    return [
        'NAME.required' => 'A Student Name is required',
        'FATHER_NAME.required'  => 'A father name is required',
        'PRESENT_ADDRESS.required'=> 'A Present Address is required',
        'PERMANENT_ADDRESS.required'=> 'A Permanent ADDRESS is required',
        'GUARDIAN.required'=> 'A GUARDIAN name is required',
        'SLC_NO.required'=> 'A School leaving certidicate NO is required',
        'PASSING_YEAR.required'=> 'A School PASSING YEAR is required',
        'IMAGE.mimes'=> 'Image should be jpeg,jpg,png,gif,jfif format ',
        'IMAGE.max'=> ' image size should not exceed 10mb',
        'SESSION_ID.required'=> 'A SESSION is required',
        'CLASS_ID.required'=> 'A CLASS is required',
        'SECTION_ID.required'=> 'A SECTION is required',
    ];
}
}
