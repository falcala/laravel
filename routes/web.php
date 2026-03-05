
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;

// use App\Http\Controllers\ProfileController;

Route::get('/', [PageController::class, 'welcome'])->name('welcome');

// ── Guest only ────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// ── Authenticated ─────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
         ->name('logout');

    Route::get('/dashboard', function () {
        return view('content.dashboard.dashboards-analytics');
    })->name('dashboard');

    // Roles & Users CRUD
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    // ── Page builder ──────────────────────────────────────────────────
    Route::prefix('pages')->name('pages.')->group(function () {

        Route::get('/welcome/edit',   [PageController::class, 'edit'])->name('edit');
        Route::post('/welcome/update',[PageController::class, 'update'])->name('update');

        // Add section
        Route::post('/welcome/sections', [PageController::class, 'addSection'])
             ->name('sections.add');

        // !! All fixed-segment routes MUST come before {section} wildcard !!
        Route::post('/sections/reorder', [PageController::class, 'reorderSections'])
             ->name('sections.reorder');

        Route::post('/sections/upload-slide-image', [PageController::class, 'uploadSlideImage'])
             ->name('sections.upload-slide-image');

        // Wildcard {section} routes — always last
        Route::post('/sections/{section}/toggle', [PageController::class, 'toggleSection'])
             ->name('sections.toggle');

        Route::post('/sections/{section}',   [PageController::class, 'updateSection'])
             ->name('sections.update');

        Route::delete('/sections/{section}', [PageController::class, 'deleteSection'])
             ->name('sections.delete');

    });

});
