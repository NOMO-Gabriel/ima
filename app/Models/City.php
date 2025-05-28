<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relations
    public function centers(): HasMany
    {
        return $this->hasMany(Center::class);
    }

    public function cityAssignments(): HasMany
    {
        return $this->hasMany(CityAssignment::class);
    }
}
