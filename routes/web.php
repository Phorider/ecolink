<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WasteRequestController as AdminWasteRequestController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Citizen\WasteRequestController as CitizenWasteRequestController;
use App\Http\Controllers\Collector\RequestController as CollectorRequestController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Guest-only authentication routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Citizen routes
    Route::middleware('role:citizen')->prefix('citizen')->name('citizen.')->group(function () {
        Route::resource('requests', CitizenWasteRequestController::class)
            ->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    // Collector routes
    Route::middleware('role:collector')->prefix('collector')->name('collector.')->group(function () {
        Route::get('available', [CollectorRequestController::class, 'available'])->name('available');
        Route::post('requests/{wasteRequest}/accept', [CollectorRequestController::class, 'accept'])->name('accept');
        Route::get('jobs', [CollectorRequestController::class, 'jobs'])->name('jobs');
        Route::post('requests/{wasteRequest}/collect', [CollectorRequestController::class, 'markCollected'])->name('collect');
        Route::get('completed', [CollectorRequestController::class, 'completed'])->name('completed');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('requests', [AdminWasteRequestController::class, 'index'])->name('requests.index');
        Route::get('requests/{wasteRequest}', [AdminWasteRequestController::class, 'show'])->name('requests.show');
        Route::delete('requests/{wasteRequest}', [AdminWasteRequestController::class, 'destroy'])->name('requests.destroy');
    });
});
