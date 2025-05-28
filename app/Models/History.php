<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Example of call:
 *
 * log_history('updated', $user, [
 *   'before' => ['name' => $oldName],
 *   'after' => ['name' => $newName],
 * ], "Nom de l'utilisateur modifié.");
 *
 * -> Types of action: 'created', 'updated', 'deleted', 'validated', 'suspended', 'rejected', 'archived'
 */
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
}