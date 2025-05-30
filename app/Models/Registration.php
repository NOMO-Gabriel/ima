<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// === Registration.php ===
class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'contract',
        'student_id',
        'center_id',
        'special_conditions',
    ];

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'formation_registration');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
}
