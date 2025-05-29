<?php

// app/Models/TransactionReason.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'direction',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec les transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'reason_id');
    }

    /**
     * Scope pour les raisons d'entrée (IN)
     */
    public function scopeIncoming($query)
    {
        return $query->where('direction', 'IN');
    }

    /**
     * Scope pour les raisons de sortie (OUT)
     */
    public function scopeOutgoing($query)
    {
        return $query->where('direction', 'OUT');
    }

    /**
     * Accessor pour le label avec direction
     */
    public function getLabelWithDirectionAttribute()
    {
        return $this->label . ' (' . $this->direction . ')';
    }

    /**
     * Accessor pour la couleur selon la direction
     */
    public function getDirectionColorClassAttribute()
    {
        return $this->direction === 'IN' ? 'text-success' : 'text-danger';
    }

    /**
     * Accessor pour le badge de direction
     */
    public function getDirectionBadgeAttribute()
    {
        if ($this->direction === 'IN') {
            return '<span class="badge bg-success">IN</span>';
        }
        return '<span class="badge bg-danger">OUT</span>';
    }

    /**
     * Statistiques pour cette raison
     */
    public function getStatsAttribute()
    {
        return [
            'total_transactions' => $this->transactions()->count(),
            'valid_transactions' => $this->transactions()->valid()->count(),
            'total_amount' => $this->transactions()->valid()->sum('amount'),
            'average_amount' => $this->transactions()->valid()->avg('amount'),
        ];
    }
}
