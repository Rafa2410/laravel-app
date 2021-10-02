<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    use HasFactory;
    /**
     * Get the company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get user data
     */
    public function getUser($id) {
        return User::findOrFail($id);
    }
}
