<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserSettingsRequest extends FormRequest
{
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
            'fav_categories' => [
                'required',
                'array',
                'max:3'
            ],
            'fav_categories.*' => [
                'required',
                'string'
            ],

            'fav_sources' => [
                'required',
                'array',
                'max:3'
            ],
            'fav_sources.*' => [
                'required',
                'string'
            ],

            'fav_authors' => [
                'required',
                'array',
                'max:3'
            ],
            'fav_authors.*' => [
                'required',
                'string'
            ],
        ];
    }
}
