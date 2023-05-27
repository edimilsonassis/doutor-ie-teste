<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookIndex extends Model
{
    use HasFactory;

    public function indexes()
    {
        return $this->belongsTo(BookIndex::class, 'id');
    }

}