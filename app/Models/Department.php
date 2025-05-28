<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'academy_id',
        'head_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relations
    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }
}
