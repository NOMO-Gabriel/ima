<?php

// app/Models/Transaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'description',
        'valid',
        'reason_id',
        'receiver_id',
        'center_id',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'valid' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec la raison de la transaction
     */
    public function reason()
    {
        return $this->belongsTo(TransactionReason::class, 'reason_id');
    }

    /**
     * Relation avec le bénéficiaire
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Relation avec le centre
     */
    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    /**
     * Relation avec l'utilisateur qui a créé la transaction
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope pour les transactions valides
     */
    public function scopeValid($query)
    {
        return $query->where('valid', true);
    }

    /**
     * Scope pour les transactions invalides
     */
    public function scopeInvalid($query)
    {
        return $query->where('valid', false);
    }

    /**
     * Scope pour les entrées (IN)
     */
    public function scopeIncoming($query)
    {
        return $query->whereHas('reason', function ($q) {
            $q->where('direction', 'IN');
        });
    }

    /**
     * Scope pour les sorties (OUT)
     */
    public function scopeOutgoing($query)
    {
        return $query->whereHas('reason', function ($q) {
            $q->where('direction', 'OUT');
        });
    }

    /**
     * Scope pour une plage de dates
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope pour un centre spécifique
     */
    public function scopeForCenter($query, $centerId)
    {
        return $query->where('center_id', $centerId);
    }

    /**
     * Accessor pour le montant formaté
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Accessor pour le montant avec signe
     */
    public function getSignedAmountAttribute()
    {
        $sign = $this->reason->direction === 'IN' ? '+' : '-';
        return $sign . $this->formatted_amount;
    }

    /**
     * Accessor pour la couleur selon la direction
     */
    public function getAmountColorClassAttribute()
    {
        return $this->reason->direction === 'IN' ? 'text-success' : 'text-danger';
    }

    /**
     * Accessor pour le badge de direction
     */
    public function getDirectionBadgeAttribute()
    {
        if ($this->reason->direction === 'IN') {
            return '<span class="badge bg-success">Entrée</span>';
        }
        return '<span class="badge bg-danger">Sortie</span>';
    }

    /**
     * Accessor pour le badge de statut
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->valid) {
            return '<span class="badge bg-success">Valide</span>';
        }
        return '<span class="badge bg-warning">Invalide</span>';
    }
}
