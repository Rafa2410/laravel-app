<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    /**
     * Get the company that owns the plant.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getCompany($id) {
        return Company::findOrFail($id);
    }

    /**
     * Get the rooms of the plant.
     */
    public function plant()
    {
        return $this->hasMany(Room::class);
    }
}
