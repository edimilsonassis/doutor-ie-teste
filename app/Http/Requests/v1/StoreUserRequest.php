<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
                'required',
                'string',
                'max:255',
                'min:6',
                'max:50'
            ],
            'email'    => [
                'required',
                'string',
                'email',
                'min:6',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:20'
            ],
        ];
    }
}