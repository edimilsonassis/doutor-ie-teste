<?php

namespace App\Http\Requests\v1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'     => [
                'nullable',
                'string',
                'max:255',
                'min:6',
                'max:50'
            ],
            'email'    => [
                'nullable',
                'string',
                'email',
                'min:6',
                'max:255',
                Rule::unique('users')->ignore((int) $this->route('user')),
            ],
            'password' => [
                'nullable',
                'string',
                'min:6',
                'max:20'
            ],
        ];
    }
}