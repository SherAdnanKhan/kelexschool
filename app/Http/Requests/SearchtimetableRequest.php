<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchtimetableRequest extends FormRequest
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
            'SECTION_ID'=>'required',
            'day'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'GROUP_ID.required'=> 'A Subject Group is required ',
            'CLASS_ID.required'=> 'A Class is required  ',
            'SECTION_ID.required'=> 'A SECTION is required',
            'day.required'=> 'A Day is required',
          
        ];
    }
}
