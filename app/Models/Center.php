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
        'location',
        'city_id',
        'nb_students',
        'director_id',
        'head_id',
        'logistics_director_id',
        'finance_director_id',
        'academic_manager_id',
        'staff_ids',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'staff_ids' => 'array',
        'is_active' => 'boolean',
        'nb_students' => 'integer',
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

    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function logisticsDirector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'logistics_director_id');
    }

    public function financeDirector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'finance_director_id');
    }

    public function academicManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'academic_manager_id');
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
