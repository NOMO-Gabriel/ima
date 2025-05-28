<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    /** @use HasFactory<\Database\Factories\CommandFactory> */
    use HasFactory;

    public function commandUnits()
    {
        return $this->hasMany(CommandUnit::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
