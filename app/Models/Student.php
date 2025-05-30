<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'establishment',
        'user_id',
        'parent_phone_number',
        'full_registered',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registration()
    {
        return $this->hasOne(Registration::class);
    }
     public function enrollments(): HasMany // <--- CHANGÉ DE HasOne à HasMany
    {
        return $this->hasMany(Registration::class, 'student_id');
    }
}
