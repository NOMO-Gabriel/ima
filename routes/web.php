<?php

use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EntranceExamController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MockExamController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionHistoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', fn () => redirect('/' . Session::get('locale', 'en')));
Route::get('/dashboard', fn () => redirect()->route('dashboard', ['locale' => app()->getLocale()]))->name('dashboard.redirect');

// Change language
Route::get('/language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'fr'])) {
        abort(400);
    }

    // Save the selected language in the session
    Session::put('locale', $locale);

    // Reconstruct the URL
    $previousUrl = url()->previous();
    $segments = explode('/', parse_url($previousUrl, PHP_URL_PATH));

    // Remplace language segment
    if (isset($segments[1]) && in_array($segments[1], ['en', 'fr'])) {
        $segments[1] = $locale;
    } else {
        // Add lang segment at the beginning
        array_splice($segments, 1, 0, [$locale]);
    }

    $newPath = implode('/', $segments);
    $newUrl = url($newPath);

    return redirect($newUrl);
})->name('language');


Route::prefix('{locale}')
    ->where(['locale' => 'en|fr'])
    ->middleware('set.locale')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('welcome');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

        // Authentification
        // Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            // Profile
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::post('/profile/photo', [ProfilePhotoController::class, 'store'])->name('profile.photo.store');
            Route::delete('/profile/photo', [ProfilePhotoController::class, 'destroy'])->name('profile.photo.destroy');

            // Protected by admin role
            // Route::prefix('admin')->name('admin.')->middleware(['role:pca|dg-prepas|sg|da|df-national|dln'])->group(function () {
                Route::prefix('admin')->name('admin.')->group(function () {
                // Administration
                Route::resource('staff', StaffController::class);
                Route::resource('teachers', TeacherController::class);
                Route::resource('students', StudentController::class);

                // Gestion
                Route::resource('academies', AcademyController::class);
                Route::resource('cities', CityController::class);
                Route::resource('centers', CenterController::class);
                Route::resource('departments', DepartmentController::class);
                Route::resource('phases', PhaseController::class);
                Route::resource('formations', FormationController::class);
                Route::resource('rooms', RoomController::class);
                Route::resource('courses', CourseController::class);
                Route::resource('entrance-exams', EntranceExamController::class);
                Route::resource('mock-exams', MockExamController::class);

                // Planification
                Route::resource('planning', TimetableController::class);
                Route::resource('absences', AbsencesController::class);

                // Finances
                Route::resource('registrations', RegistrationController::class);
                Route::resource('transactions', TransactionController::class);
                Route::resource('transactions-history', TransactionHistoryController::class);

                // Ressources
                Route::resource('books', BookController::class);
                Route::resource('materials', MaterialController::class);

                // Compte
                Route::resource('profile', ProfileController::class);
                Route::resource('history', HistoryController::class);

                // Others
                Route::resource('slots', SlotController::class);
            });

            // User only
            Route::prefix('admin/users')->name('admin.users.')->middleware('permission:user.view.any')->group(function () {
                Route::resource('/', UserController::class)->parameters(['' => 'user']);
                Route::put('{user}/roles', [UserController::class, 'updateRoles'])
                    ->middleware('permission:user.role.assign')
                    ->name('update-roles');
            });
        });
    // });

// require __DIR__.'/auth.php';
