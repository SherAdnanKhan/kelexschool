<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class session_batchrequest extends FormRequest
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
           'sb_name'=>'required|max:255',
            'start_date'=>'required',
            'end_date' =>'required',
            'type'=>'required',
        ];
    }

     public function messages()
    {
        return[
            'sb_name.required' => "Session Batches Name is required",
            'start_date.max' => "Session Batches Name can't be greater than 255 characters",
            'start_date.required' => "Start Date is required",
            'end_date.required' => "End Date is required",
            'type.required' => "Type Field is required",
    ];
    }
}
