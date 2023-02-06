<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherApplicationRequest extends FormRequest
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
                'APPLICATION_TYPE'=>'required',
                'START_DATE'=>'required',
                'END_DATE' =>'required',
                'APPLICATION_DESCRIPTION'=>'required|max:1000',
            ];
        
    }
    public function messages()
    {
        return[
            'APPLICATION_TYPE.required' => "Application type is required",
            'START_DATE.required' => "Start Date is required",
            'END_DATE.required' => "End Date is required",
            'APPLICATION_DESCRIPTION.required' => "Application description is required",
            'APPLICATION_DESCRIPTION.max' => "Application description can't be greater than 1000 characters",
    ];
    }
}
