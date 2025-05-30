<?php

use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\CommandController;
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
use App\Http\Controllers\InstallmentController;
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
use App\Models\Installment;
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
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            // Profile
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::post('/profile/photo', [ProfilePhotoController::class, 'store'])->name('profile.photo.store');
            Route::delete('/profile/photo', [ProfilePhotoController::class, 'destroy'])->name('profile.photo.destroy');

            // Protected by admin role
            Route::prefix('admin')->name('admin.')->middleware(['role:pca|dg-prepas|sg|da|df-national|dln'])->group(function () {
                Route::get('planning', [TimetableController::class, 'index'])->name('planning.index');
                Route::post('planning/change-formation', [TimetableController::class, 'changeFormation'])->name('planning.change-formation');

                // Slots routes avec actions spécifiques
                Route::prefix('slots')->name('slots.')->group(function () {
                    Route::get('create', [SlotController::class, 'create'])->name('create');
                    Route::post('/', [SlotController::class, 'store'])->name('store');
                    Route::get('{slot}/edit', [SlotController::class, 'edit'])->name('edit');
                    Route::put('{slot}', [SlotController::class, 'update'])->name('update');
                    Route::delete('{slot}', [SlotController::class, 'destroy'])->name('destroy');
                });

                Route::resource('transactions', TransactionController::class);
                Route::get('transactions-stats', [TransactionController::class, 'stats'])->name('transactions.stats');
                Route::get('transactions-export', [TransactionController::class, 'export'])->name('transactions.export');

                // =====================================
                // GESTION DES UTILISATEURS - SÉPARÉE
                // =====================================

                // Personnel administratif
                Route::prefix('staff')->name('staff.')->group(function () {
                    Route::get('/', [StaffController::class, 'index'])->name('index');
                    Route::get('/create', [StaffController::class, 'create'])->name('create');
                    Route::post('/', [StaffController::class, 'store'])->name('store');
                    Route::get('/{staffUser}', [StaffController::class, 'show'])->name('show');
                    Route::get('/{staffUser}/edit', [StaffController::class, 'edit'])->name('edit');
                    Route::put('/{staffUser}', [StaffController::class, 'update'])->name('update');
                    Route::delete('/{staffUser}', [StaffController::class, 'destroy'])->name('destroy');
                    Route::put('/{staffUser}/permissions', [StaffController::class, 'updateDirectPermissions'])->name('update-permissions');
                });

                // Enseignants
                Route::prefix('teachers')->name('teachers.')->group(function () {
                    Route::get('/', [TeacherController::class, 'index'])->name('index');
                    Route::get('/create', [TeacherController::class, 'create'])->name('create');
                    Route::post('/', [TeacherController::class, 'store'])->name('store');
                    Route::get('/{teacherUser}', [TeacherController::class, 'show'])->name('show');
                    Route::get('/{teacherUser}/edit', [TeacherController::class, 'edit'])->name('edit');
                    Route::put('/{teacherUser}', [TeacherController::class, 'update'])->name('update');
                    Route::delete('/{teacherUser}', [TeacherController::class, 'destroy'])->name('destroy');
                    Route::put('/{teacherUser}/permissions', [TeacherController::class, 'updateDirectPermissions'])->name('update-permissions');
                });

                // Étudiants
                Route::prefix('students')->name('students.')->group(function () {
                    Route::get('/', [StudentController::class, 'index'])->name('index');
                    Route::get('/create', [StudentController::class, 'create'])->name('create');
                    Route::post('/', [StudentController::class, 'store'])->name('store');
                    Route::get('/{studentUser}', [StudentController::class, 'show'])->name('show');
                    Route::get('/{studentUser}/edit', [StudentController::class, 'edit'])->name('edit');
                    Route::put('/{studentUser}', [StudentController::class, 'update'])->name('update');
                    Route::delete('/{studentUser}', [StudentController::class, 'destroy'])->name('destroy');
                });

                // Gestion globale des utilisateurs (pour vue d'ensemble)
                Route::prefix('users')->name('users.')->group(function () {
                    Route::get('/', [UserController::class, 'index'])->name('index');
                    Route::get('/create', [UserController::class, 'create'])->name('create');
                    Route::post('/', [UserController::class, 'store'])->name('store');
                    Route::get('/{user}', [UserController::class, 'show'])->name('show');
                    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
                    Route::put('/{user}', [UserController::class, 'update'])->name('update');
                    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
                    Route::put('/{user}/roles', [UserController::class, 'updateRoles'])->name('update-roles');
                });

                // =====================================
                // AUTRES MODULES
                // =====================================

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

                Route::prefix('absences')->name('absences.')->group(function () {
                    Route::get('/', [AbsencesController::class, 'index'])->name('index');
                    Route::get('/rooms', [AbsencesController::class, 'getRooms'])->name('rooms');
                    Route::get('/students', [AbsencesController::class, 'getStudents'])->name('students');
                    Route::post('/', [AbsencesController::class, 'store'])->name('store');
                });

                // Finances
                Route::resource('registrations', RegistrationController::class);
                Route::resource('transactions-history', TransactionHistoryController::class);

                // Finance - Validation des inscriptions
                Route::prefix('finance')->name('finance.')->group(function () {
                    // Routes personnalisées pour les installments
                    Route::get('/installments', [InstallmentController::class, 'index'])->name('installments.index');
                    Route::get('/installments/create', [InstallmentController::class, 'create'])->name('installments.create');
                    Route::post('/installments', [InstallmentController::class, 'store'])->name('installments.store');
                    Route::get('/installments/{installment}', [InstallmentController::class, 'show'])->name('installments.show');
                    Route::get('/installments/{installment}/edit', [InstallmentController::class, 'edit'])->name('installments.edit');
                    Route::put('/installments/{installment}', [InstallmentController::class, 'update'])->name('installments.update');
                    Route::delete('/installments/{installment}', [InstallmentController::class, 'destroy'])->name('installments.destroy');


                    Route::prefix('students')->name('students.')->group(function () {
                        Route::get('/pending', [App\Http\Controllers\FinanceRegistrationController::class, 'pendingStudents'])->name('pending');
                        Route::get('/{student}', [App\Http\Controllers\FinanceRegistrationController::class, 'showStudent'])->name('show');
                        Route::get('/{student}/finalize', [App\Http\Controllers\FinanceRegistrationController::class, 'finalizeRegistration'])->name('finalize');
                        Route::post('/{student}/process', [App\Http\Controllers\FinanceRegistrationController::class, 'processRegistration'])->name('process');
                        Route::get('/confirmation/{registration}', [App\Http\Controllers\FinanceRegistrationController::class, 'confirmationRegistration'])->name('confirmation');
                        Route::post('/{student}/reject', [App\Http\Controllers\FinanceRegistrationController::class, 'rejectStudent'])->name('reject');
                        Route::get('/completed', [App\Http\Controllers\FinanceRegistrationController::class, 'completedRegistrations'])->name('completed');
                    });
                });

                // Ressources
                Route::resource('books', BookController::class);
                Route::resource('materials', MaterialController::class);
                Route::resource('commands', CommandController::class);

                // Compte
                Route::resource('profile', ProfileController::class);
                Route::resource('history', HistoryController::class);

                // Others
            });
        });
     });

require __DIR__.'/auth.php';
