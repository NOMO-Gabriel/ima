<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if ($this->user && !$this->user->can('book.catalog.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $query = Book::query();

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filtre par langue
        if ($request->filled('lang')) {
            $query->where('lang', $request->lang);
        }

        // Filtre par disponibilité
        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('quantity', '>', 0);
            } elseif ($request->availability === 'unavailable') {
                $query->where('quantity', '<=', 0);
            }
        }

        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Tri
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'title-asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title-desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'author-asc':
                    $query->orderBy('author', 'asc');
                    break;
                case 'author-desc':
                    $query->orderBy('author', 'desc');
                    break;
                case 'quantity-asc':
                    $query->orderBy('quantity', 'asc');
                    break;
                case 'quantity-desc':
                    $query->orderBy('quantity', 'desc');
                    break;
                case 'year-asc':
                    $query->orderBy('publicationYear', 'asc');
                    break;
                case 'year-desc':
                    $query->orderBy('publicationYear', 'desc');
                    break;
            }
        } else {
            $query->orderBy('title', 'asc');
        }

        $books = $query->paginate(15);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if ($this->user && !$this->user->can('book.catalog.add')) {
        //     abort(403, 'Non autorisé');
        // }

        $formations = Formation::all();
        $categories = $this->getBookCategories();
        $languages = $this->getLanguages();

        return view('admin.books.create', compact('formations', 'categories', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if ($this->user && !$this->user->can('book.catalog.add')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publicationYear' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'lang' => 'nullable|string|max:5',
            'nb_pages' => 'nullable|integer|min:1',
            'quantity' => 'required|integer|min:0',
            'coverImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'formations' => 'nullable|array',
            'formations.*' => 'exists:formations,id',
        ]);

        // Gestion de l'image de couverture
        if ($request->hasFile('coverImage')) {
            $coverPath = $request->file('coverImage')->store('book-covers', 'public');
            $validated['coverImage'] = $coverPath;
        }

        $book = Book::create($validated);

        // Association avec les formations si spécifiées
        if (isset($validated['formations'])) {
            $book->formations()->sync($validated['formations']);
        }

        log_history('created', $book, ['before' => [], 'after' => $book]);

        return redirect()->route('admin.books.index', ['locale' => app()->getLocale()])
            ->with('success', 'Livre ajouté avec succès au catalogue.');
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Book $book)
    {
        // if ($this->user && !$this->user->can('book.catalog.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $book->load('formations');
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Book $book)
    {
        // if ($this->user && !$this->user->can('book.catalog.update')) {
        //     abort(403, 'Non autorisé');
        // }

        $formations = Formation::all();
        $categories = $this->getBookCategories();
        $languages = $this->getLanguages();

        return view('admin.books.edit', compact('book', 'formations', 'categories', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Book $book)
    {
        // if ($this->user && !$this->user->can('book.catalog.update')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publicationYear' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'lang' => 'nullable|string|max:5',
            'nb_pages' => 'nullable|integer|min:1',
            'quantity' => 'required|integer|min:0',
            'coverImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'formations' => 'nullable|array',
            'formations.*' => 'exists:formations,id',
        ]);

        // Gestion de l'image de couverture
        if ($request->hasFile('coverImage')) {
            // Supprimer l'ancienne image si elle existe
            if ($book->coverImage) {
                Storage::disk('public')->delete($book->coverImage);
            }
            $coverPath = $request->file('coverImage')->store('book-covers', 'public');
            $validated['coverImage'] = $coverPath;
        }

        $book->update($validated);

        // Mise à jour des associations avec les formations
        if (isset($validated['formations'])) {
            $book->formations()->sync($validated['formations']);
        } else {
            $book->formations()->detach();
        }

        log_history('updated', $book, ['before' => $book->toArray(), 'after' => $validated]);

        return redirect()->route('admin.books.index', ['locale' => app()->getLocale()])
            ->with('success', 'Livre mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Book $book)
    {
        // if ($this->user && !$this->user->can('book.catalog.remove')) {
        //     abort(403, 'Non autorisé');
        // }

        // Supprimer l'image de couverture si elle existe
        if ($book->coverImage) {
            Storage::disk('public')->delete($book->coverImage);
        }

        // Détacher les formations associées
        $book->formations()->detach();

        $book->delete();

        log_history('deleted', $book, ['before' => $book->toArray(), 'after' => []]);

        return redirect()->route('admin.books.index', ['locale' => app()->getLocale()])
            ->with('success', 'Livre supprimé avec succès du catalogue.');
    }

    /**
     * Get available book categories
     */
    private function getBookCategories()
    {
        return [
            'Mathématiques',
            'Physique',
            'Chimie',
            'Biologie',
            'Français',
            'Anglais',
            'Histoire-Géographie',
            'Philosophie',
            'Économie',
            'Droit',
            'Informatique',
            'Littérature',
            'Sciences Sociales',
            'Préparation concours',
            'Méthodologie',
            'Culture générale',
            'Autres'
        ];
    }

    /**
     * Get available languages
     */
    private function getLanguages()
    {
        return [
            'FR' => 'Français',
            'EN' => 'Anglais'
        ];
    }
}
