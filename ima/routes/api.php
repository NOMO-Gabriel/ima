<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AcademyController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\CenterController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;

// Préfixe de version API
Route::prefix('v1')->group(function () {

    // Routes d'authentification
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        // Vérification d'email (si implémentée)
        Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

        // Routes d'authentification protégées
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail']);
        });
    });

    // Routes protégées par authentification
    Route::middleware('auth:sanctum')->group(function () {
        // Profil utilisateur actuel
        Route::get('/me', [ProfileController::class, 'me']);

        // Routes de profil utilisateur
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'show']);
            Route::put('/', [ProfileController::class, 'update']);
            Route::post('/change-password', [ProfileController::class, 'changePassword']);
            Route::post('/photo', [ProfileController::class, 'updateProfilePhoto']);
        });

        // Routes de gestion des utilisateurs
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/search', [UserController::class, 'search']); // Placer avant la route avec paramètre
            Route::get('/{user}', [UserController::class, 'show']);
            Route::put('/{user}', [UserController::class, 'update']);
            Route::delete('/{user}', [UserController::class, 'destroy']);
            Route::post('/{user}/restore', [UserController::class, 'restore']); // Pour les modèles avec SoftDeletes
            Route::put('/{user}/status', [UserController::class, 'updateStatus']);
            Route::post('/{user}/photo', [UserController::class, 'updateProfilePhoto']);
            Route::put('/{user}/password', [UserController::class, 'updatePassword']);
        });

        // Routes pour les académies
        Route::apiResource('academies', AcademyController::class);
        Route::put('/academies/{academy}/toggle-status', [AcademyController::class, 'toggleStatus']);

        // Routes pour les départements
        Route::apiResource('departments', DepartmentController::class);
        Route::put('/departments/{department}/toggle-status', [DepartmentController::class, 'toggleStatus']);
        Route::get('/academies/{academyId}/departments', [DepartmentController::class, 'getByAcademy']);

        // Routes pour les centres
        Route::apiResource('centers', CenterController::class);
        Route::put('/centers/{center}/toggle-status', [CenterController::class, 'toggleStatus']);
        Route::get('/academies/{academyId}/centers', [CenterController::class, 'getByAcademy']);

        // Routes pour les villes
        Route::apiResource('cities', CityController::class);
        Route::put('/cities/{city}/toggle-status', [CityController::class, 'toggleStatus']);
        Route::get('/regions/{region}/cities', [CityController::class, 'getByRegion']);
        Route::get('/cities/{city}/financial-directors', [CityController::class, 'getFinancialDirectors']);
        Route::get('/cities/{city}/logistics-directors', [CityController::class, 'getLogisticsDirectors']);
        Route::get('/cities/{city}/financial-agents', [CityController::class, 'getFinancialAgents']);

        // Routes pour les rôles
        Route::apiResource('roles', RoleController::class);
        Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions']);
        Route::get('/roles/{role}/users', [RoleController::class, 'getUsers']);

        // Routes pour les permissions
        Route::apiResource('permissions', PermissionController::class);
        Route::get('/permissions/{permission}/roles', [PermissionController::class, 'getRoles']);
    });

    // Route de vérification du statut de l'API
    Route::get('/status', function () {
        return response()->json([
            'status' => 'online',
            'version' => '1.0',
            'server_time' => now()->toIso8601String()
        ]);
    });
});

// Fallback pour les routes non trouvées
Route::fallback(function() {
    return response()->json([
        'message' => 'Resource not found'
    ], 404);
});
