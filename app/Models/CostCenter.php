<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    /**
     * Get the plant that owns the cost center.
     */
    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
