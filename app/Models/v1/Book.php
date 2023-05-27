<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function indexes()
    {
        return $this->hasMany(BookIndex::class, 'id')->with('indexes');
    }

}