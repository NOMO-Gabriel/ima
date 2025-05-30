<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'hours',
        'price',
        'phase_id',
        'academy_id',
    ];

    protected $casts = [
        'hours' => 'integer',
        'price' => 'integer',
    ];

    public function students()
    {
        return Student::whereIn('id', function ($query) {
            $query->select('student_id')
                ->from('registrations')
                ->join('formation_registration', 'formation_registration.registration_id', '=', 'registrations.id')
                ->where('formation_registration.formation_id', $this->id);
        })->get();
    }

    // Relations
    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_formations');
    }

    public function entranceExams(): BelongsToMany
    {
        return $this->belongsToMany(EntranceExam::class, 'entrance_exam_formations');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public function mockExams(): HasMany
    {
        return $this->hasMany(MockExam::class);
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'formation_books');
    }

    public function registrations()
    {
        return $this->belongsToMany(Registration::class, 'formation_registration');
    }
}
