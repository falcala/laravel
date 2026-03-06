
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\GoogleController;

// use App\Http\Controllers\ProfileController;

Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/vcard/{section}', [PageController::class, 'downloadVcard'])->name('vcard.download');
Route::get('/u/{nickname}', [FrontPageController::class, 'show'])->name('frontpages.show');

// ── Google OAuth ───────────────────────────────────────────────────────────
Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

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

    // ── Media manager ─────────────────────────────────────────────────
    Route::get('/media/manager',    [MediaController::class, 'manager'])->name('media.manager');
    Route::get('/media/tree',       [MediaController::class, 'tree'])->name('media.tree');
    Route::get('/media',            [MediaController::class, 'index'])->name('media.index');
    Route::post('/media/upload',    [MediaController::class, 'upload'])->name('media.upload');
    Route::post('/media/rename',    [MediaController::class, 'rename'])->name('media.rename');
    Route::delete('/media',         [MediaController::class, 'destroy'])->name('media.destroy');
    Route::post('/media/folders',   [MediaController::class, 'createFolder'])->name('media.folders.create');
    Route::delete('/media/folders', [MediaController::class, 'deleteFolder'])->name('media.folders.delete');

    // ── Front Pages (per-user) ────────────────────────────────────────
    Route::prefix('frontpages')->name('frontpages.')->group(function () {
        Route::get('/',                         [FrontPageController::class, 'index'])->name('index');
        Route::post('/sections/reorder',        [FrontPageController::class, 'reorderSections'])->name('sections.reorder');
        Route::post('/sections/upload-slide-image', [FrontPageController::class, 'uploadSlideImage'])->name('sections.upload-slide-image');
        Route::post('/sections/{section}/toggle',   [FrontPageController::class, 'toggleSection'])->name('sections.toggle');
        Route::post('/sections/{section}',          [FrontPageController::class, 'updateSection'])->name('sections.update');
        Route::delete('/sections/{section}',        [FrontPageController::class, 'deleteSection'])->name('sections.delete');
        Route::get('/{user}/edit',                  [FrontPageController::class, 'edit'])->name('edit');
        Route::post('/{user}/update',               [FrontPageController::class, 'update'])->name('update');
        Route::post('/{user}/sections',             [FrontPageController::class, 'addSection'])->name('sections.add');
    });

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
