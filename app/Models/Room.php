<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * Get the plant that owns the room.
     */
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
