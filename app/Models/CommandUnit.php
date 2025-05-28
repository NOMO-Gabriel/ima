<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommandUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'material_id',
        'command_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relations
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function command(): BelongsTo
    {
        return $this->belongsTo(Command::class);
    }
}
