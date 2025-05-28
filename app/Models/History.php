<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'user_id',
        'subject_type',
        'subject_id',
        'action',
        'changes',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo(null, 'subject_type', 'subject_id');
    }

    /**
     * Instruction: Don't forget to import this model by "use App\Models\History;"
     *
     * Example of call:
     *
     * $history = History::log([
     *     'subject_type' => User::class,
     *     'subject_id' => $user->id,
     *     'action' => 'updated',
     *     'changes' => [
     *         'before' => ['name' => $oldName],
     *         'after' => ['name' => $newName],
     *     ],
     *     'description' => "Nom de l'utilisateur modifié.",
     * ]);
     */
    public static function log(array $params): self
    {
        return self::create([
            'user_id'      => $params['user_id'] ?? auth()->id,
            'subject_type' => $params['subject_type'],
            'subject_id'   => $params['subject_id'],
            'action'       => $params['action'],
            'changes'      => $params['changes'] ?? null,
            'description'  => $params['description'] ?? null,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
        ]);
    }
}