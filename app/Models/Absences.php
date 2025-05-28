<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absences extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'slot_id',
    ];

    // Relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }
}
