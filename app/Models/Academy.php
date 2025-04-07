<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'location',
        'director_id',
        'created_by',
        'updated_by',
    ];

    /**
     * Les relations avec d'autres modèles.
     */
    
    /**
     * Obtient le directeur de l'académie.
     */
    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    