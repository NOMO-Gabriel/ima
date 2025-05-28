<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publicationYear',
        'isbn',
        'category',
        'description',
        'lang',
        'nb_pages',
        'coverImage',
        'quantity',
    ];

    protected $casts = [
        'publicationYear' => 'integer',
        'nb_pages' => 'integer',
        'quantity' => 'integer',
    ];

    // Relations
    public function formations(): BelongsToMany
    {
        return $this->belongsToMany(Formation::class, 'formation_books');
    }
}
