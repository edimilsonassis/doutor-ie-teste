<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    const RELATION_USER = 'user';
    const RELATION_BOOKS_INDEXES = 'indexes';

    const COLUMN_ID = 'id';
    const COLUMN_TITULO = 'titulo';
    const COLUMN_INDICES = 'indices';
    const COLUMN_USUARIO_PUBLICADOR_ID = 'usuario_publicador_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_TITULO,
        self::COLUMN_INDICES,
        self::COLUMN_USUARIO_PUBLICADOR_ID,
    ];

    public function user()
    {
        return $this->hasOne(User::class, User::COLUMN_ID, self::COLUMN_USUARIO_PUBLICADOR_ID);
    }

    public function parentindexes()
    {
        return $this->hasMany(BookIndex::class, 'livro_id')
            ->whereNull('indice_pai_id')->with('parentindexes');
    }

    public function indexes()
    {
        return $this->hasMany(BookIndex::class, 'livro_id')
            ->whereNull('indice_pai_id');
    }
}