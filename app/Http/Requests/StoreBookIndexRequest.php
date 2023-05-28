<?php

namespace App\Http\Requests;

use App\Models\v1\Book;
use App\Models\v1\BookIndex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookIndexRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule','array','string>
     */
    public function rules(): array
    {
        return [
            BookIndex::COLUMN_INDICE_PAI_ID => [
                Rule::exists('book', Book::COLUMN_ID),
                'integer',
            ],
            BookIndex::COLUMN_LIVRO_ID => [
                'required',
                'integer'
            ],
            BookIndex::COLUMN_PAGINA => [
                'required',
                'integer'
            ],
            BookIndex::COLUMN_TITULO => [
                Rule::unique('books_indexes', BookIndex::COLUMN_ID),
                'required',
                'string',
                'min:1',
                'max:100'
            ],
        ];
    }
}