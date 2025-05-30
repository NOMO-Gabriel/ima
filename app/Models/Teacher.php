<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary',
        'cni',
        'matricule',
        'birthdate',
        'birthplace',
        'profession',
        'department',
        'academy_id',
        'department_id',
        'city_id',
        'user_id',
    ];

    protected $casts = [
        'salary' => 'decimal:2',
        'birthdate' => 'date',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function city(): BelongsTo 
    { 
        return $this->belongsTo(City::class); 
    }
}
