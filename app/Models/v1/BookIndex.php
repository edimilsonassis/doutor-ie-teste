<?php

namespace App\Models\v1;

use App\Http\Resources\v1\BookResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookIndex extends Model
{
    use HasFactory;

    protected $table = 'books_indexes';

    const RELATION_PARENTS = 'parents';
    const RELATION_BOOKS_INDEXES = 'indexes';

    const COLUMN_ID = 'id';
    const COLUMN_TITULO = 'titulo';
    const COLUMN_PAGINA = 'pagina';
    const COLUMN_LIVRO_ID = 'livro_id';
    const COLUMN_INDICE_PAI_ID = 'indice_pai_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_TITULO,
        self::COLUMN_PAGINA,
        self::COLUMN_LIVRO_ID,
        self::COLUMN_INDICE_PAI_ID,
    ];

    public function parentbook()
    {
        return $this->belongsTo(Book::class, 'livro_id')->with('indexes.subindexes');
    }

    public function parentindexes()
    {
        return $this->belongsTo(BookIndex::class, 'id', 'indice_pai_id')->with('parentindexes');
    }

    public function subindexes()
    {
        return $this->hasMany(BookIndex::class, 'indice_pai_id')->with('subindexes');
    }
}