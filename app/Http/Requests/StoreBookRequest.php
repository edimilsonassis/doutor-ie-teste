<?php

namespace App\Http\Requests;

use App\Models\v1\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule','array','string>
     */
    public function rules(): array
    {
        return [
            Book::COLUMN_TITULO => [
                'required',
                'string',
                'max:100'
            ],
            Book::COLUMN_USUARIO_PUBLICADOR_ID => [
                'required',
                'integer',
            ]
        ];
    }
}