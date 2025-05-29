<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Center extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'address',
        'contact_email',
        'contact_phone',
        'is_active',
        'staff_ids',
        'city_id',
        'director_id',
        'logistics_director_id',
        'finance_director_id',
        'academy_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'staff_ids' => 'array',
        'is_active' => 'boolean',
    ];

    // Relations
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    public function logisticsDirector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'logistics_director_id');
    }

    public function financeDirector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'finance_director_id');
    }

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class, 'academy_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function assignations(): HasMany
    {
        return $this->hasMany(Assignation::class);
    }

    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }
}
