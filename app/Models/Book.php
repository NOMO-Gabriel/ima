<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'quantity'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publicationYear' => 'integer',
        'nb_pages' => 'integer',
        'quantity' => 'integer',
    ];

    /**
     * Get the formations associated with this book.
     */
    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'formation_books');
    }

    /**
     * Get the cover image URL.
     */
    public function getCoverImageUrlAttribute()
    {
        if ($this->coverImage) {
            return Storage::url($this->coverImage);
        }
        return asset('images/default-book-cover.png');
    }

    /**
     * Check if the book is available (quantity > 0).
     */
    public function getIsAvailableAttribute()
    {
        return $this->quantity > 0;
    }

    /**
     * Get the availability status text.
     */
    public function getAvailabilityStatusAttribute()
    {
        if ($this->quantity > 5) {
            return 'Disponible';
        } elseif ($this->quantity > 0) {
            return 'Stock limité';
        } else {
            return 'Indisponible';
        }
    }

    /**
     * Get the availability status color class.
     */
    public function getAvailabilityColorAttribute()
    {
        if ($this->quantity > 5) {
            return 'text-green-600 bg-green-100';
        } elseif ($this->quantity > 0) {
            return 'text-yellow-600 bg-yellow-100';
        } else {
            return 'text-red-600 bg-red-100';
        }
    }

    /**
     * Scope to filter books by availability.
     */
    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope to filter books by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to filter books by language.
     */
    public function scopeByLanguage($query, $language)
    {
        return $query->where('lang', $language);
    }

    /**
     * Scope to search books by title, author, or publisher.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhere('publisher', 'like', "%{$search}%")
                ->orWhere('isbn', 'like', "%{$search}%");
        });
    }

    /**
     * Get the full title with author for display.
     */
    public function getFullTitleAttribute()
    {
        return $this->title . ($this->author ? ' - ' . $this->author : '');
    }

    /**
     * Get a short description (limited to 100 characters).
     */
    public function getShortDescriptionAttribute()
    {
        if (!$this->description) {
            return 'Aucune description disponible.';
        }

        return strlen($this->description) > 100
            ? substr($this->description, 0, 100) . '...'
            : $this->description;
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Delete cover image when book is deleted
        static::deleting(function($book) {
            if ($book->coverImage) {
                Storage::disk('public')->delete($book->coverImage);
            }
        });
    }
}
