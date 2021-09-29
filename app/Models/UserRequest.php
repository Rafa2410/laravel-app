<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    /**
     * Get the user for the requests.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function getUser($id) {
        return User::findOrFail($id);
    }
}
