<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntranceExam extends Model
{
    /** @use HasFactory<\Database\Factories\EntranceExamFactory> */
    use HasFactory;

    public function students()
    {
        return $this->belongsToMany(User::class);
    }
}
