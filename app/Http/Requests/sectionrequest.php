<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sectionrequest extends FormRequest
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
            'Section_name'=>'required',
            'Classes_id'=>'required',
        ];
    }
    public function messages()
    {
        return[
       'Section_name.required' => "Section Name is required",
        'Classes_id.required' => "Classes Name is required",
    ];
    }
}
