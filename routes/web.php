<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestResearchController;
use App\Http\Controllers\Head\ResearchCodeController;
use App\Http\Controllers\ThemeController;

// Public routes
Route::get('/', [WelcomeController::class, 'index']);
Route::get('/research/{id}', [WelcomeController::class, 'getResearchDetails']);

// Research DataTable API (Global Search)
Route::get('/api/research/data', [WelcomeController::class, 'getResearchData'])->name('api.research.data');

Route::get('/api/research/{id}', [WelcomeController::class, 'getResearchDetails'])->where('id', '[0-9]+')->name('api.research.details');
Route::get('/api/research/{id}/download', [WelcomeController::class, 'downloadResearch'])->where('id', '[0-9]+')->name('api.research.download');
Route::post('/guest/filepond/upload', [GuestResearchController::class, 'filepondUpload'])->name('guest.filepond.upload');
Route::delete('/guest/filepond/revert', [GuestResearchController::class, 'filepondRevert'])->name('guest.filepond.revert');

// Routes for guest users to submit research via code
Route::get('/guest/research/enter-code', [GuestResearchController::class, 'showEnterCodeForm'])->name('guest.research.enter_code');
Route::post('/guest/research/verify-code', [GuestResearchController::class, 'verifyCode'])->name('guest.research.verify_code');

// Group the routes that require a valid code
Route::middleware('research_code_access')->group(function () {
    Route::get('/guest/research/form', [GuestResearchController::class, 'showResearchForm'])->name('guest.research.form');
    Route::post('/guest/research/store', [GuestResearchController::class, 'storeResearch'])->name('guest.research.store');
});
Route::get('/debug-role', function() {
    $user = Auth::user();
    if (!$user) return 'Not logged in';
    
    return [
        'Name' => $user->name,
        'Current Roles' => $user->getRoleNames(),
        'Is Super Admin?' => $user->hasRole('Super Admin'),
        'Is Research Staff?' => $user->hasRole('Research Staff'),
        'Has Old Role (head)?' => $user->hasRole('head'),
        'Has Old Role (user)?' => $user->hasRole('user'),
    ];
});
// Statistics API
Route::get('/api/statistics', [WelcomeController::class, 'getStatistics'])->name('api.statistics');
Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');
Route::get('/light-mode', function () {
    session(['dark_mode' => false]);
    return redirect()->back();
});

// Dashboard Redirect Logic
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/dashboard', function () {
    $user = Auth::user();
    
    // Default to Super Admin dashboard (view folder 'head')
    if ($user->hasRole('Super Admin')) {
        return redirect()->route('head.dashboard');
    }
    
    // Otherwise go to Research Staff dashboard (view folder 'user')
    return redirect()->route('user.dashboard');
})->name('dashboard');

// Common accessible routes
Route::get('/head/codes', [ResearchCodeController::class, 'index'])->name('head.codes.index');

// SUPER ADMIN ROUTES (Formerly Head)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:Super Admin' // UPDATED ROLE
])->prefix('head')->name('head.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/codes', [ResearchCodeController::class, 'index'])->name('codes.index');
    Route::post('/codes/generate', [ResearchCodeController::class, 'generate'])->name('codes.generate');
    Route::get('/codes/all', [ResearchCodeController::class, 'fetchAllCodes'])->name('codes.all');
    
    // Unique name to avoid conflict
    Route::get('/api/research/{research}', [ResearchController::class, 'getResearchData'])->name('api.research.info');

    Route::get('research/generate-report', [ResearchController::class, 'generateReport'])->name('research.generate-report');
    Route::get('research/statistics', [StatisticsController::class, 'index'])->name('research.statistics');
    Route::patch('research/{research}/status', [ResearchController::class, 'changeStatus'])->name('research.status');
    Route::get('research/approvals', [ResearchController::class, 'showApprovals'])->name('research.approvals');
    Route::patch('research/{research}/approve', [ResearchController::class, 'approve'])->name('research.approve');
    Route::patch('research/{research}/reject', [ResearchController::class, 'reject'])->name('research.reject');
    Route::get('research/{research}/download', [ResearchController::class, 'download'])->name('research.download');
    Route::post('research/filepond-upload', [ResearchController::class, 'filepondUpload'])->name('research.filepond-upload');
    Route::post('research/filepond-revert', [ResearchController::class, 'filepondRevert'])->name('research.filepond-revert');
    Route::get('research/all', [ResearchController::class, 'all'])->name('research.all');
    Route::get('research/pending', [ResearchController::class, 'pending'])->name('research.pending');
    Route::get('/filepond/load/{research}', [ResearchController::class, 'loadFile'])->name('filepond.load');
    Route::delete('/filepond/remove', [ResearchController::class, 'removeFile'])->name('filepond.remove');
    
    Route::resource('research', ResearchController::class);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    Route::patch('/users/{user}/toggle-login', [UserController::class, 'toggleLogin'])->name('users.toggle-login');
    Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [StatisticsController::class, 'reports'])->name('index');
        Route::get('/export', [StatisticsController::class, 'exportCsv'])->name('export');
        Route::post('/custom', [StatisticsController::class, 'customReport'])->name('custom');
    });
    
    Route::get('/users/import', [UserController::class, 'importForm'])->name('users.import.form');
    Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
});

// RESEARCH STAFF ROUTES (Formerly User)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:Research Staff' // UPDATED ROLE
])->prefix('user')->name('user.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/codes', [ResearchCodeController::class, 'index'])->name('codes.index');
    Route::post('/codes/generate', [ResearchCodeController::class, 'generate'])->name('codes.generate');
    Route::get('/codes/all', [ResearchCodeController::class, 'fetchAllCodes'])->name('codes.all');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    // Unique name to avoid conflict
    Route::get('/api/research/{research}', [ResearchController::class, 'getResearchData'])->name('api.research.info');

    Route::get('research/generate-report', [ResearchController::class, 'generateReport'])->name('research.generate-report');
    Route::get('research/statistics', [StatisticsController::class, 'index'])->name('research.statistics');
    Route::patch('research/{research}/status', [ResearchController::class, 'changeStatus'])->name('research.status');
    Route::get('research/approvals', [ResearchController::class, 'showApprovals'])->name('research.approvals');
    Route::patch('research/{research}/approve', [ResearchController::class, 'approve'])->name('research.approve');
    Route::patch('research/{research}/reject', [ResearchController::class, 'reject'])->name('research.reject');
    Route::get('research/{research}/download', [ResearchController::class, 'download'])->name('research.download');
    Route::post('research/filepond-upload', [ResearchController::class, 'filepondUpload'])->name('research.filepond-upload');
    Route::post('research/filepond-revert', [ResearchController::class, 'filepondRevert'])->name('research.filepond-revert');
    Route::get('research/all', [ResearchController::class, 'all'])->name('research.all');
    Route::get('research/pending', [ResearchController::class, 'pending'])->name('research.pending');
    Route::get('research/browse', [ResearchController::class, 'browse'])->name('research.browse');
    Route::get('/filepond/load/{research}', [ResearchController::class, 'loadFile'])->name('filepond.load');
    Route::delete('/filepond/remove', [ResearchController::class, 'removeFile'])->name('filepond.remove');

    Route::resource('research', ResearchController::class);

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [StatisticsController::class, 'reports'])->name('index');
        Route::get('/export', [StatisticsController::class, 'exportCsv'])->name('export');
        Route::post('/custom', [StatisticsController::class, 'customReport'])->name('custom');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/research/generate-report', [StatisticsController::class, 'generateReport'])
        ->name('research.generate-report');
    Route::get('/research-statistics/generate-report', [StatisticsController::class, 'generateReport'])
        ->name('statistics.generate-report');
    
    // Resource route accessible to both if not blocked by specific group middleware
    Route::resource('research', ResearchController::class);
});