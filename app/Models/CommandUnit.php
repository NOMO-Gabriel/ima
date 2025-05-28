<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandUnit extends Model
{
    /** @use HasFactory<\Database\Factories\CommandUnitFactory> */
    use HasFactory;

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function command()
    {
        return $this->belongsTo(Command::class);
    }

}
