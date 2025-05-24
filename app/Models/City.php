<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

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
}