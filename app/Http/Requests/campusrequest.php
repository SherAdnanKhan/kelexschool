<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class campusrequest extends FormRequest
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
            'schoolname' => 'required|max:255',
            'schooladdress' => 'required|max:255',
            'phoneno' => 'required|max:255',
            'city' =>   'required|max:255',
            'instuition'=> 'required|max:255',
            'schoolemail'=>'required|',
            'status'=>  'required|max:10',
            'smsstatus'=>  'required|max:10',
            'billingcharges' => 'required|max:255',
            'discount' => 'required|max:255',
            'billingdate' => 'required',
            'schoollogo'=>'mimes:jpeg,jpg,png,gif|max:10000',
            'schoolemail' => 'required|email'
        ];
    }

    public function messages()
    {
        return[
            
            'schoolname.required' => "School Name is required",
            'schoolname.max' => "School Name can not be greater than 255 characters",
  
            'schooladdress.required' => "School Address is required",
            'schooladdress.max' => "School Address can not be greater than 255 characters",
            'phoneno.required' => "Phone Number is required",
            'phoneno.max' => "Phone Number can not be greater than 255 characters",

            'city.required' => "City Name is required",
            'city.max' => "City Name can not be greater than 255 characters",

            'instuition.required' => "Instuition Name is required",
            'instuition.max' => "Instuition Name can not be greater than 255 characters",
  
            'status.required' => "Status is required",
            'status.max' => "status can not be greater than 10 characters",

            'smsstatus.required' => "Sms status is required",
            'smsstatus.max' => "Sms status can not be greater than 10 characters",
            
            'billingcharges.required' => "Billing Charges Field is required",
            'billingcharges.max' => "Billing Charges Field can not be greater than 255 characters",

            'discount.required' => "Discount Field is required",
            'discount.max' => "Discount Field can not be greater than 255 characters",
            
            'billingdate.required' => "Billing Date is required",

            'schoollogo.mimes' => "File must be of type Image (jpeg,jpg,png,gif)",
            'schoollogo.max' => "File size cannot be greater than 10000 kb ",

            'schoolemail.required' => "Email is required",
            'schoolemail.email' => "Email Address must be valid",
            
        ];
            
        
    }
}
