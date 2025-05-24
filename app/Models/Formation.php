<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'hours',
        'phase_id',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_formations');
    }

    public function entranceExams()
    {
        return $this->hasMany(EntranceExam::class);
    }
}
