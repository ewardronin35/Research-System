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

// Public routes
Route::get('/', [WelcomeController::class, 'index']);
Route::get('/research/{id}', [WelcomeController::class, 'getResearchDetails']);
// Research DataTable API
Route::get('/api/research', [WelcomeController::class, 'getResearchData'])->name('api.research.data');
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
Route::get('/head/codes', [ResearchCodeController::class, 'index'])->name('head.codes.index');

// Head routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:head'
])->prefix('head')->name('head.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/codes', [ResearchCodeController::class, 'index'])->name('codes.index');
    Route::post('/codes/generate', [ResearchCodeController::class, 'generate'])->name('codes.generate');
    Route::get('/codes/all', [ResearchCodeController::class, 'fetchAllCodes'])->name('codes.all');


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
        Route::get('/approvals', [ResearchController::class, 'showApprovals'])->name('approvals');

// Route to handle the approval action
 Route::patch('/{research}/approve', [ResearchController::class, 'approve'])->name('approve');

// Route to handle the rejection action
Route::patch('/{research}/reject', [ResearchController::class, 'reject'])->name('reject');
  
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

// Head routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:user'
])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/codes', [ResearchCodeController::class, 'index'])->name('codes.index');
    Route::post('/codes/generate', [ResearchCodeController::class, 'generate'])->name('codes.generate');
    Route::get('/codes/all', [ResearchCodeController::class, 'fetchAllCodes'])->name('codes.all');


Route::prefix('research')->name('research.')->group(function () {
    // Page Display Routes
    Route::get('/', [ResearchController::class, 'index'])->name('index');
    Route::get('/create', [ResearchController::class, 'create'])->name('create');
    Route::get('/approvals', [ResearchController::class, 'showApprovals'])->name('approvals');
    Route::get('/{research}', [ResearchController::class, 'show'])->name('show');
    Route::get('/{research}/edit', [ResearchController::class, 'edit'])->name('edit');
    Route::get('/browse', [ResearchController::class, 'browse'])->name('browse');

    // Action/Form Submission Routes
    Route::post('/', [ResearchController::class, 'store'])->name('store');
    Route::put('/{research}', [ResearchController::class, 'update'])->name('update');
    Route::delete('/{research}', [ResearchController::class, 'destroy'])->name('destroy');

    // Approval/Rejection Routes
    Route::patch('/{research}/approve', [ResearchController::class, 'approve'])->name('approve');
    Route::patch('/{research}/reject', [ResearchController::class, 'reject'])->name('reject');

    // File Handling & Report Routes
    Route::get('/{research}/download', [ResearchController::class, 'download'])->name('download');
    // Note: The 'generate-report' route is defined OUTSIDE this group, which is correct.
});

// The FilePond and Report routes should be right after the group, still inside the user section
Route::post('/research/filepond-upload', [ResearchController::class, 'filepondUpload'])
    ->name('research.filepond-upload');

Route::post('/research/filepond-revert', [ResearchController::class, 'filepondRevert'])
    ->name('research.filepond-revert');
     
Route::get('/research/generate-report', [ResearchController::class, 'generateReport'])
    ->name('research.generate-report'); // Full name will be user.research.generate-report
// ...


    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [StatisticsController::class, 'reports'])->name('index');
        Route::get('/export', [StatisticsController::class, 'exportCsv'])->name('export');
        Route::post('/custom', [StatisticsController::class, 'customReport'])->name('custom');
    });

    
});


