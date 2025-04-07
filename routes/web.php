<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route de la landing page
Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Routes d'authentification gérées par Breeze
Route::middleware('auth')->group(function () {
    // Routes du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes pour la gestion des photos de profil
    Route::post('/profile/photo', [ProfilePhotoController::class, 'store'])->name('profile.photo.store');
    Route::delete('/profile/photo', [ProfilePhotoController::class, 'destroy'])->name('profile.photo.destroy');
    
    // Route du dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Routes pour l'administration (protégées par middleware de permission)
    Route::prefix('admin')->name('admin.')->middleware(['role:PCA|DG-PREPAS|SG|DA|DF-Nationale|DLN'])->group(function () {
        // Gestion des utilisateurs
        Route::resource('users', UserController::class);
        
        // Gestion des académies
        Route::resource('academies', AcademyController::class);
        
        // Gestion des départements
        Route::resource('departments', DepartmentController::class);
    });
});

require __DIR__.'/auth.php';