<?php

namespace App\Services\v1;

use App\Models\v1\BookIndex;
use App\Http\Requests\v1\StoreBookIndexRequest;
use Illuminate\Support\Facades\Validator;

class BookIndexService
{
    /**
     * Create indexes
     */
    public static function recursiveCreateIndexes(array $indexes, int $bookId, ?int $parentId = null)
    {
        foreach ($indexes as $indexe) {
            $indexe_extended = [
                BookIndex::COLUMN_INDICE_PAI_ID => $parentId,
                BookIndex::COLUMN_LIVRO_ID => $bookId,
                BookIndex::COLUMN_TITULO => $indexe['titulo'] ?? null,
                BookIndex::COLUMN_PAGINA => $indexe['pagina'] ?? null,
            ];

            $validatedData = Validator::make($indexe_extended, StoreBookIndexRequest::internalRules())->validate();

            $bookIndexe = BookIndex::create($validatedData);

            if (isset($indexe['indices'])) {
                self::recursiveCreateIndexes($indexe['indices'], $bookId, $bookIndexe->id);
            }
        }
    }

    public static function recursiveConverteXML(\SimpleXMLElement $item)
    {
        $array = [
            BookIndex::COLUMN_TITULO => (string) $item['titulo'][0] ?? null,
            BookIndex::COLUMN_PAGINA => (string) $item['pagina'][0] ?? null,
        ];

        if (isset($item->item))
            foreach ($item->item as $subitem) {
                $array['indices'][] = self::recursiveConverteXML($subitem);
            }

        return $array;
    }

}