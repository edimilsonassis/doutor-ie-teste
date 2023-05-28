<?php

namespace App\Http\Requests;

use App\Models\v1\BookIndex;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookIndexRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            BookIndex::COLUMN_LIVRO_ID => 'required|integer',
            BookIndex::COLUMN_INDICE_PAI_ID => 'integer',
            BookIndex::COLUMN_PAGINA => 'required|integer',
            BookIndex::COLUMN_TITULO => 'required|string|min:1|max:100',
        ];
    }
}