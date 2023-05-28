<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    const RELATION_USER = 'user';
    const RELATION_BOOK_INDEXES = 'indexes';

    const COLUMN_ID = 'id';
    const COLUMN_TITULO = 'titulo';
    const COLUMN_USUARIO_PUBLICADOR_ID = 'usuario_publicador_id';

    public function user()
    {
        return $this->belongsTo(User::class, User::COLUMN_ID);
    }

    public function indexes()
    {
        return $this->hasMany(BookIndex::class, BookIndex::COLUMN_ID)->with('indexes');
    }

    public function parents()
    {
        return $this->hasMany(BookIndex::class, BookIndex::COLUMN_ID)->with('parents');
    }

}