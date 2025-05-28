<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'user_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commandUnits(): HasMany
    {
        return $this->hasMany(CommandUnit::class);
    }
}
