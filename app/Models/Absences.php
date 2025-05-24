<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    /** @use HasFactory<\Database\Factories\AbsencesFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'slot_id'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
