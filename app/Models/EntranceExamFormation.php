<?php

/// === EntranceExamFormation.php ===
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntranceExamFormation extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'entrance_exam_id',
    ];

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function entranceExam(): BelongsTo
    {
        return $this->belongsTo(EntranceExam::class);
    }
}
