<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavetimetableRequest extends FormRequest
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
            "SUBJECT_ID"    => "required|array|min:1",
            "SUBJECT_ID.*"  => "required|string|min:1",

            "EMP_ID"    => "required|array|min:1",
            "EMP_ID.*"  => "required|string|min:1",

            "TIMEFROM"    => "required|array|min:1",
            "TIMEFROM.*"  => "required|string|distinct|min:1",
           
            "TIMETO"    => "required|array|min:1",
            "TIMETO.*"  => "required|string|distinct|min:1",
        ];
    }
    public function messages()
    {
        return [
            'SUBJECT_ID.required'=> 'please fill required Subject ',
            'EMP_ID.required'=> 'please fill required Employee',
            'TIMEFROM.required'=> 'please fill required Time form',
            'TIMETO.required'=> 'please fill required Time to ',
        ];
    }
}
