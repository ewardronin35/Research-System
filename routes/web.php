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
    if ($user->hasRole(['head', 'user'])) {
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
    Route::get('/api/research/{research}', [ResearchController::class, 'getResearchData'])->name('api.research.data');


    // Research Management Routes for Head

    // Now, define ONLY your extra, non-resourceful routes for research
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

    // Route to remove an existing file
    Route::delete('/filepond/remove', [ResearchController::class, 'removeFile'])->name('filepond.remove');
 Route::resource('research', ResearchController::class);
    

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
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');


    Route::get('/api/research/{research}', [ResearchController::class, 'getResearchData'])->name('api.research.data');


    // Research Management Routes for Head

    // Now, define ONLY your extra, non-resourceful routes for research
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

    // Route to remove an existing file
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
    // Report generation route - available to all authenticated users
    Route::get('/research/generate-report', [App\Http\Controllers\StatisticsController::class, 'generateReport'])
        ->name('research.generate-report');
        Route::get('/research-statistics/generate-report', [App\Http\Controllers\StatisticsController::class, 'generateReport'])
        ->name('statistics.generate-report');
            Route::resource('research', ResearchController::class);

});
