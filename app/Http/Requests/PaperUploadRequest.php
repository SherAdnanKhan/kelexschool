<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaperUploadRequest extends FormRequest
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
            'UPLOADFILE'   => 'mimes:doc,pdf,docx,zip'
        ];
    }
    public function messages()
    {
        return[
            'UPLOADFILE.mimes' => "mimes:doc,pdf,docx,zip",
        ];
    }
}
