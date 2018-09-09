<?php

namespace App\Http\Requests;

use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateTeamRequest extends FormRequest
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
            //
            'name'=>'required|string|max:100|unique:teams',
            'slug'=>'required|string|max:100|unique:teams'
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw (new CustomValidationException($validator));
    }
}
