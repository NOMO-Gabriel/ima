<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignation extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'center_id',
    ];

    // Relations
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
