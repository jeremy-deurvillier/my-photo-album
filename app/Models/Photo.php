<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    /**
     * Get Album for a Photo.
     */
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
