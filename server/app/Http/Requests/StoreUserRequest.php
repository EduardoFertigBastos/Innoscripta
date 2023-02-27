<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class StoreUserRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'validatePasswordLowercase',
            function ($attribute, $value, $parameters) {
                return !!preg_match("#[a-z]+#", $value);
            },
            'The password must contain lowercase letters!'
        );

        $validationFactory->extend(
            'validatePasswordUppercase',
            function ($attribute, $value, $parameters) {
                return !!preg_match("#[A-Z]+#", $value);
            },
            'The password must contain uppercase letters!'
        );
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'validatePasswordLowercase',
                'validatePasswordUppercase',
                'confirmed'
            ],
        ];
    }
}
