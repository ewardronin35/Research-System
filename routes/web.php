<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', [WelcomeController::class, 'index']);
Route::get('/research/{id}', [WelcomeController::class, 'getResearchDetails']);
// Research DataTable API
Route::get('/api/research', [WelcomeController::class, 'getResearchData'])->name('api.research.data');
Route::get('/api/research/{id}', [WelcomeController::class, 'getResearchDetails'])->where('id', '[0-9]+')->name('api.research.details');
Route::get('/api/research/{id}/download', [WelcomeController::class, 'downloadResearch'])->where('id', '[0-9]+')->name('api.research.download');

// Statistics API
Route::get('/api/statistics', [WelcomeController::class, 'getStatistics'])->name('api.statistics');
Route::post('/theme/toggle', [App\Http\Controllers\ThemeController::class, 'toggle'])->name('theme.toggle');
Route::get('/light-mode', function () {
    session(['dark_mode' => false]);
    return redirect()->back();
});

// Dashboard route interceptor - will redirect based on roles
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/dashboard', function () {
    $user = Auth::user();
    
    // Log the user's current role for debugging
    \Log::info('User Dashboard Access', [
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_role' => $user->role,
        'user_roles' => $user->getRoleNames()
    ]);

    // Default to user dashboard if no specific role is assigned
    if ($user->hasRole(['head', 'admin'])) {
        return redirect()->route('head.dashboard');
    }
    
    return redirect()->route('user.dashboard');
})->name('dashboard');

// Head routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:head'
])->prefix('head')->name('head.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Research Management Routes for Head
    Route::prefix('research')->name('research.')->group(function () {
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');
        Route::patch('/{research}/status', [ResearchController::class, 'changeStatus'])->name('status');
        Route::get('/all', [ResearchController::class, 'all'])->name('all');
        Route::get('/pending', [ResearchController::class, 'pending'])->name('pending');
        Route::get('/', [ResearchController::class, 'index'])->name('index');
        Route::get('/browse', [ResearchController::class, 'browse'])->name('browse');
        Route::post('/store', [ResearchController::class, 'store'])->name('store');
        Route::get('/approved', [ResearchController::class, 'approved'])->name('approved');
        Route::get('/{research}/download', [ResearchController::class, 'download'])->name('download');
  
    });
    Route::post('/research/filepond-upload', [ResearchController::class, 'filepondUpload'])
    ->name('research.filepond-upload');
Route::post('/research/filepond-revert', [ResearchController::class, 'filepondRevert'])
    ->name('research.filepond-revert');
     
        Route::get('/research/generate-report', [ResearchController::class, 'generateReport'])
    ->name('research.generate-report')
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    // User Management Routes for Head
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // User login toggle
    Route::patch('/users/{user}/toggle-login', [UserController::class, 'toggleLogin'])->name('users.toggle-login');
    
    // Reset password
    Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [StatisticsController::class, 'reports'])->name('index');
        Route::get('/export', [StatisticsController::class, 'exportCsv'])->name('export');
        Route::post('/custom', [StatisticsController::class, 'customReport'])->name('custom');
    });
    // CSV import
    Route::get('/users/import', [UserController::class, 'importForm'])->name('users.import.form');
    Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
    
});

// User routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:user'
])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Research Management Routes for Users
    Route::prefix('research')->name('research.')->group(function () {
        Route::get('/', [ResearchController::class, 'index'])->name('index');
        Route::get('/create', [ResearchController::class, 'create'])->name('create');
        Route::post('/', [ResearchController::class, 'store'])->name('store');
        Route::get('/{research}', [ResearchController::class, 'show'])->name('show');
        Route::get('/{research}/edit', [ResearchController::class, 'edit'])->name('edit');
        Route::put('/{research}', [ResearchController::class, 'update'])->name('update');
        Route::delete('/{research}', [ResearchController::class, 'destroy'])->name('destroy');
        Route::get('/{research}/download', [ResearchController::class, 'download'])->name('download');
        Route::get('/browse', [ResearchController::class, 'browse'])->name('browse');
        Route::get('/statistics', [ResearchController::class, 'statistics'])->name('statistics');
        Route::get('/reports', [ResearchController::class, 'reports'])->name('reports');
    });
    Route::post('/research/filepond-upload', [ResearchController::class, 'filepondUpload'])
    ->name('research.filepond-upload');
Route::post('/research/filepond-revert', [ResearchController::class, 'filepondRevert'])
    ->name('research.filepond-revert');
    Route::get('/research/generate-report', [ResearchController::class, 'generateReport'])
    ->name('research.generate-report');
    // Repository browsing for Users
    Route::get('/repository', [ResearchController::class, 'browse'])->name('repository');
});
// Remove all these conflicting routes:
// Route::get('/research/generate-report', [ResearchController::class, 'generateReport'])->name('research.generate-report');
// Route::get('/research/generate-report', [ResearchController::class, 'generateReport'])->name('research.generate-report')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
// Route::get('/statistics/generate-report', [App\Http\Controllers\StatisticsController::class, 'generateReport'])->name('statistics.generate-report');

// Add this single, clean route in the authenticated routes group:
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Report generation route - available to all authenticated users
    Route::get('/research/generate-report', [App\Http\Controllers\StatisticsController::class, 'generateReport'])
        ->name('research.generate-report');
        Route::get('/research-statistics/generate-report', [App\Http\Controllers\StatisticsController::class, 'generateReport'])
        ->name('statistics.generate-report');
});
Route::get('/user-roles', function() {
    $user = Auth::user();
    return [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role_column' => $user->role,
        'assigned_roles' => $user->getRoleNames(),
        'has_head_role' => $user->hasRole('head'),
        'has_user_role' => $user->hasRole('user'),
    ];
});