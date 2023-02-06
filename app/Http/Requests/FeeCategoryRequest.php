<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return MYSQLI_DATA_TRUNCATED;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'CLASS_ID'=>'required',
            // 'SECTION_ID'=>'required',
            'CATEGORY' =>'required|max:255',
            'SHIFT'=>'required',
        ];
    }

    public function messages()
    {
        return [
            // 'CLASS_ID.required' => "Class ID is required",

            // 'SECTION_ID.required' => "Section ID is required",

            'CATEGORY.required' => "Category Field is required",

            'CATEGORY.max' => "Category Field can't be greater than 255 characters",

            'SHIFT.required' => "Shift Field is required",
        ];

    }
}
