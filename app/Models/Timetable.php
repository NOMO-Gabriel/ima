<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_start_date',
        'day_start_time',
        'day_end_time',
        'center_id',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'day_start_time' => 'datetime:H:i:s',
        'day_end_time' => 'datetime:H:i:s',
    ];

    // Relations
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    /**
     * Créer un emploi du temps vide pour une semaine donnée
     * Les slots seront créés à la demande par l'utilisateur
     */
    public static function createForWeek(Center $center, Carbon $weekStart): self
    {
        return self::create([
            'center_id' => $center->id,
            'week_start_date' => $weekStart->toDateString(),
            'day_start_time' => '08:00:00',
            'day_end_time' => '16:30:00',
        ]);
    }

    /**
     * Obtenir ou créer un emploi du temps pour une semaine donnée
     */
    public static function getOrCreateForWeek(Center $center, Carbon $weekStart): self
    {
        $timetable = $center->timetables()
            ->whereDate('week_start_date', $weekStart)
            ->first();

        if (!$timetable) {
            $timetable = self::createForWeek($center, $weekStart);
        }

        return $timetable;
    }

    /**
     * Vérifier si un slot existe pour un créneau donné
     */
    public function hasSlot(string $weekDay, string $startTime, string $endTime, int $roomId, int $formationId): bool
    {
        return $this->slots()
            ->where('week_day', $weekDay)
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->where('room_id', $roomId)
            ->where('formation_id', $formationId)
            ->exists();
    }

    /**
     * Obtenir tous les slots d'une formation pour cette semaine
     */
    public function getFormationSlots(int $formationId)
    {
        return $this->slots()
            ->where('formation_id', $formationId)
            ->with(['room', 'course', 'formation', 'teacher'])
            ->get();
    }
}
