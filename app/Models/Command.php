<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'direction',
        'material_id',
        'user_id',
        'city_id',
        'center_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the material that this command belongs to.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the user who created this command.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the city associated with this command.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the center associated with this command.
     */
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * Get the direction label in French.
     */
    public function getDirectionLabelAttribute(): string
    {
        return $this->direction === 'in' ? 'Entrée' : 'Sortie';
    }

    /**
     * Get the direction icon.
     */
    public function getDirectionIconAttribute(): string
    {
        return $this->direction === 'in' ? '↗️' : '↙️';
    }

    /**
     * Get the direction color for UI.
     */
    public function getDirectionColorAttribute(): string
    {
        return $this->direction === 'in'
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800';
    }

    /**
     * Get the total value of this command.
     */
    public function getTotalValueAttribute(): int
    {
        return $this->quantity * $this->material->price;
    }

    /**
     * Get the formatted total value with currency.
     */
    public function getFormattedTotalValueAttribute(): string
    {
        return number_format($this->total_value, 0, ',', ' ') . ' XAF';
    }

    /**
     * Get the formatted date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Get the human readable date.
     */
    public function getHumanDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Scope to filter by direction.
     */
    public function scopeDirection($query, string $direction)
    {
        return $query->where('direction', $direction);
    }

    /**
     * Scope to filter by material.
     */
    public function scopeForMaterial($query, int $materialId)
    {
        return $query->where('material_id', $materialId);
    }

    /**
     * Scope to get recent commands.
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope to order by most recent.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope to order by oldest.
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}