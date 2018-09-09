<?php

namespace App\Http\Requests;
use App\Exceptions\CustomValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginUserRequest extends FormRequest
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
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw (new CustomValidationException($validator));
    }
}
