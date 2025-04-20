<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'region',
        'country',
        'is_active',
        'created_by',
        'updated_by'
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Obtenir les centres associés à cette ville.
     */
    public function centers(): HasMany
    {
        return $this->hasMany(Center::class);
    }

    /**
     * Obtenir les utilisateurs associés à cette ville.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Obtenir les directeurs financiers de cette ville.
     */
    public function financialDirectors()
    {
        return $this->users()->role('DF-Ville');
    }

    /**
     * Obtenir les directeurs logistiques de cette ville.
     */
    public function logisticsDirectors()
    {
        return $this->users()->role('DL-Ville');
    }
    
    /**
     * Obtenir les agents financiers de cette ville.
     */
    public function financialAgents()
    {
        return $this->users()->role('Agent-Financier');
    }

    /**
     * Obtenir l'utilisateur qui a créé cette ville.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Obtenir l'utilisateur qui a mis à jour cette ville.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}