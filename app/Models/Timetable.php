<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_start_date',
        'day_start_time',
        'day_end_time',
        'center_id',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'day_start_time' => 'datetime:H:i:s',
        'day_end_time' => 'datetime:H:i:s',
    ];

    // Relations
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
