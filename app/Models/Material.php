<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'unit',
        'stock',
        'price',
        'type',
        'user_id',
    ];

    protected $casts = [
        'stock' => 'integer',
        'price' => 'integer',
    ];

    /**
     * Get the user that created this material.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all commands for this material.
     */
    public function commands(): HasMany
    {
        return $this->hasMany(Command::class);
    }

    /**
     * Get the formatted price with currency.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', ' ') . ' XAF';
    }

    /**
     * Get the total value (stock * price).
     */
    public function getTotalValueAttribute(): int
    {
        return $this->stock * $this->price;
    }

    /**
     * Get the formatted total value with currency.
     */
    public function getFormattedTotalValueAttribute(): string
    {
        return number_format($this->total_value, 0, ',', ' ') . ' XAF';
    }

    /**
     * Get the stock status (low, medium, high).
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'empty';
        } elseif ($this->stock <= 5) {
            return 'low';
        } elseif ($this->stock <= 20) {
            return 'medium';
        } else {
            return 'high';
        }
    }

    /**
     * Get the stock status color for UI.
     */
    public function getStockStatusColorAttribute(): string
    {
        switch ($this->stock_status) {
            case 'empty':
                return 'bg-red-100 text-red-800';
            case 'low':
                return 'bg-yellow-100 text-yellow-800';
            case 'medium':
                return 'bg-blue-100 text-blue-800';
            case 'high':
                return 'bg-green-100 text-green-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    /**
     * Get the type label in French.
     */
    public function getTypeLabel(): string
    {
        $labels = [
            'booklet' => 'Livret',
            'mock_exam' => 'Examen blanc',
            'sheet' => 'Feuille',
            'other' => 'Autre',
        ];

        return $labels[$this->type] ?? 'Inconnu';
    }

    /**
     * Get the unit label in French.
     */
    public function getUnitLabel(): string
    {
        $labels = [
            'pcs' => 'Pièces',
            'kg' => 'Kilogrammes',
            'g' => 'Grammes',
            'm' => 'Mètres',
            'cm' => 'Centimètres',
            'mm' => 'Millimètres',
            'l' => 'Litres',
            'ml' => 'Millilitres',
            'm2' => 'Mètres carrés',
            'm3' => 'Mètres cubes',
            'set' => 'Ensemble',
            'box' => 'Boîte',
            'pack' => 'Pack',
        ];

        return $labels[$this->unit] ?? $this->unit;
    }

    /**
     * Scope to filter by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by low stock.
     */
    public function scopeLowStock($query, int $threshold = 5)
    {
        return $query->where('stock', '<=', $threshold);
    }

    /**
     * Scope to search by name or description.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }
}