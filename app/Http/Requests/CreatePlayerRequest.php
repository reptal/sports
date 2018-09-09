<?php

namespace App\Http\Requests;

use App\Exceptions\CustomValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreatePlayerRequest extends FormRequest
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
            'first_name'=>'required|string|max:60',
            'last_name'=>'required|string|max:60',
            'team'=>'required|exists:teams,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw (new CustomValidationException($validator));
    }
}
