<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// === Registration.php ===
class Registration extends Model
{
    use HasFactory;

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'formation_registration');
    }
}
