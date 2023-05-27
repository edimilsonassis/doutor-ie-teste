<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookIndex extends Model
{
    use HasFactory;

    public function indexes()
    {
        return $this->hasMany(BookIndex::class, 'id');
    }

    public function sub_indexes()
    {
        return $this->hasMany(BookIndex::class, 'id');
    }

}