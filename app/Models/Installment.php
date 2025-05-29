<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Installment extends Model
{
    protected $fillable = [
        'registration_id',
        'amount',
        'payment_method_id',
        'notes',
        'processed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec l'inscription
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Relation avec la méthode de paiement
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Relation avec l'utilisateur qui a traité le versement
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Accessor pour le montant formaté
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Accessor pour la date formatée
     */
    public function getFormattedPaymentDateAttribute(): string
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * Vérifier si le versement peut être modifié
     */
    public function canBeModified(): bool
    {
        return $this->created_at->diffInHours(now()) <= 24;
    }

    /**
     * Vérifier si le versement peut être supprimé
     */
    public function canBeDeleted(): bool
    {
        return $this->created_at->diffInHours(now()) <= 24;
    }

    /**
     * Scope pour les versements d'aujourd'hui
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope pour les versements de cette semaine
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope pour les versements de ce mois
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    /**
     * Scope pour filtrer par méthode de paiement
     */
    public function scopeByPaymentMethod($query, $paymentMethodId)
    {
        return $query->where('payment_method_id', $paymentMethodId);
    }

    /**
     * Scope pour filtrer par montant minimum
     */
    public function scopeMinAmount($query, $amount)
    {
        return $query->where('amount', '>=', $amount);
    }

    /**
     * Scope pour filtrer par montant maximum
     */
    public function scopeMaxAmount($query, $amount)
    {
        return $query->where('amount', '<=', $amount);
    }
}
