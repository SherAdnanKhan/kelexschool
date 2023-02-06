<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class reg_feeRequest extends FormRequest
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
            'SESSION_ID'=> 'required',
            'CLASS_ID'=>'required',
            'REGFEE'=>'required',

        ];
    }
    public function messages()
    {
        return[
            'SESSION_ID.required' => "Session is required",
            'CLASS_ID.required' => "Class is required",
            'REGFEE.required' => "Amount is required",
        ];
    }
}
