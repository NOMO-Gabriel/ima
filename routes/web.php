<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Route de redirection pour la page d'accueil
Route::get('/', function () {
    // Rediriger vers la langue par défaut ou celle en session
    $locale = Session::get('locale', 'en');
    return redirect("/{$locale}");
});

Route::get('/dashboard', function () {
    $locale = app()->getLocale();
    return redirect()->route('dashboard', ['locale' => $locale]);
})->name('dashboard.redirect');

// Groupe de routes avec préfixe de langue
Route::prefix('{locale}')
    ->where(['locale' => 'en|fr'])
    ->middleware('set.locale')
    ->group(function () {
        // Route de la landing page
        Route::get('/', [HomeController::class, 'index'])->name('welcome');

        // Contact form submission route
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

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
            Route::prefix('admin')->name('admin.')->middleware(['role:pca|dg-prepas|sg|da|df-national|dln'])->group(function () {
                Route::resource('academies', AcademyController::class);
                Route::resource('departments', DepartmentController::class);
                Route::resource('centers', CenterController::class);
                Route::resource('formations', FormationController::class);
                Route::resource('courses', CourseController::class);
                Route::resource('timetables', TimetableController::class);
                Route::resource('slots', SlotController::class);
            });

            // Routes pour la gestion des utilisateurs
            Route::prefix('admin/users')->name('admin.users.')->middleware('permission:user.view.any')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/{user}', [UserController::class, 'show'])->name('show');
                Route::put('/{user}/roles', [UserController::class, 'updateRoles'])
                    ->middleware('permission:user.role.assign')
                    ->name('update-roles');
            });
            Route::put('/admin/users/{user}/roles', [UserController::class, 'updateRoles'])
                ->middleware('permission:user.role.assign')
                ->name('admin.users.update-roles');
        });
    });

// Route pour changer de langue
Route::get('/language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'fr'])) {
        abort(400);
    }

    // Stocker la langue dans la session
    Session::put('locale', $locale);

    // Rediriger vers la page équivalente dans la nouvelle langue
    $previousUrl = url()->previous();
    $segments = explode('/', parse_url($previousUrl, PHP_URL_PATH));

    // Si le premier segment après la racine est une langue
    if (isset($segments[1]) && in_array($segments[1], ['en', 'fr'])) {
        // Remplacer le segment de langue
        $segments[1] = $locale;
    } else {
        // Ajouter le segment de langue au début
        array_splice($segments, 1, 0, [$locale]);
    }

    $newPath = implode('/', $segments);
    $newUrl = url($newPath);

    return redirect($newUrl);
})->name('language');

require __DIR__.'/auth.php';
