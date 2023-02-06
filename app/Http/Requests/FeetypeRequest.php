<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeetypeRequest extends FormRequest
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
            'CLASS_ID'=>'required',
            'SECTION_ID'=>'required',
            'FEE_CAT_ID' =>'required|max:255',
            'SHIFT'=>'required',
            'SESSION_ID'=>'required',
        ];
    }
        public function messages()
    {

        return[
            'CLASS_ID.required' => "Class ID is required",

            'SECTION_ID.required' => "Section ID is required",

            'FEE_CAT.required' => "Fee Category is required",

            'FEE_CAT.max' => "Fee Category can't be greater than 255 characters",
            
            'SHIFT.required' => "Shift Field is required",            

            'SESSION_ID.required' => "Session ID is required",

        ];
            
    }
}
