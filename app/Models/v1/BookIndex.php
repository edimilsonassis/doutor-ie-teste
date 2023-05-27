<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookIndex extends Model
{
    use HasFactory;

    const RELATION_PARENTS = 'parents';
    const RELATION_BOOK_INDEXES = 'indexes';

    const COLUMN_ID = 'id';
    const COLUMN_TITULO = 'titulo';
    const COLUMN_PAGINA = 'titulo';
    const COLUMN_LIVRO_ID = 'livro_id';
    const COLUMN_INDICE_PAI_ID = 'indice_pai_id';

    public function indexes()
    {
        return $this->hasMany(self::class, self::COLUMN_INDICE_PAI_ID, self::COLUMN_ID)->with('indexes');
    }

    public function parents()
    {
        return $this->hasMany(self::class, self::COLUMN_INDICE_PAI_ID)->with('parents');
    }
}