<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    const RELATION_USER_INDEXES = 'user';
    const RELATION_BOOK_INDEXES = 'indexes';

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function indexes()
    {
        return $this->hasMany(BookIndex::class, 'id')->with('indexes');
    }

}