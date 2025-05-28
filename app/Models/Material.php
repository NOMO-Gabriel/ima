<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'unit',
        'quantity',
        'center_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relations
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function commandUnits(): HasMany
    {
        return $this->hasMany(CommandUnit::class);
    }
}
