<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'EMP_NAME'=>'required|max:255',
            'FATHER_NAME'=>'required|max:255',
            'DESIGNATION_ID'=>'required',
            'QUALIFICATION' =>'required',
            'EMP_TYPE'=>'required',
            'ADDRESS'=>'required',
            'EMP_NO'=>'required',
            'EMP_IMAGE'=>'mimes:jpeg,jpg,png,gif|max:10000',
            'JOINING_DATE'=>'required',
        ];
    }

    public function messages()
    {

        return [

            'EMP_NAME.required' => "Employee Name is required",
            'EMP_NAME.max' => "Employee Name can not be greater than 255 characters",
  
            'FATHER_NAME.required' => "Father Name is required",
            'FATHER_NAME.max' => "Father Name can not be greater than 255 characters",

            'DESIGNATION_ID.required' => "Designation ID is required",
            

            'QUALIFICATION.required' => "Qualification Field is required",
            

            'EMP_TYPE.required' => "Employee Type is required",

            'ADDRESS.required' => "Address Field is required",

            'EMP_NO.required' => "Employee Number is required",

            'EMP_TYPE.required' => "Employee Type is required",

            'EMP_TYPE.required' => "Employee Type is required",

            'JOINING_DATE.required' => "Joining Date is required",

            'EMP_IMAGE.mimes' => "File must be of type Image (jpeg,jpg,png,gif)",
            'EMP_IMAGE.max' => "File size cannot be greater than 10000 kb ",
        ];

    }
}
