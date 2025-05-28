<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'formation_id',
    ];

    protected $casts = [
        'capacity' => 'integer',
    ];

    // Relations
    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
