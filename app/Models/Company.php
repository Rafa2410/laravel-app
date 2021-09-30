<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * Get the plants of the company.
     */
    public function plants()
    {
        return $this->hasMany(Plant::class);
    }
}
