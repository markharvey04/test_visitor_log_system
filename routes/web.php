<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController; // We will create this next

// --- PUBLIC ROUTES ---
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// --- PROTECTED ROUTES (Must be logged in) ---
Route::group(['middleware' => function ($request, $next) {
    if (!session()->has('LoggedUser')) {
        return redirect()->route('login')->with('error', 'Please login first.');
    }
    return $next($request);
}], function () {

    // 1. Dashboard (For Everyone)
    Route::get('/dashboard', [VisitorController::class, 'index'])->name('visitors.index');
    
    // 2. Visitor Actions
    // Register (Reception/Admin)
    Route::get('/register', [VisitorController::class, 'create'])->name('visitors.create');
    Route::post('/register', [VisitorController::class, 'store'])->name('visitors.store');
    // Check Out (Reception/Admin)
    Route::post('/checkout/{id}', [VisitorController::class, 'checkOut'])->name('visitors.checkout');
    // DELETE VISITOR (Admin Only)
    Route::delete('/visitor/delete/{id}', [VisitorController::class, 'destroy'])->name('visitors.delete');


    // --- ADMIN PANEL ROUTES (Role 3 Only) ---
    // We add a check inside this group to ensure only RoleID 3 enters
    Route::group(['prefix' => 'admin', 'middleware' => function ($request, $next) {
        if (session('RoleID') != 3) {
            return redirect('/dashboard')->with('error', 'Access Denied: Admins Only.');
        }
        return $next($request);
    }], function () {

        // User Management (List, Create, Store, Delete)
        Route::get('/users', [AdminController::class, 'index'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [AdminController::class, 'store'])->name('admin.users.store');
        Route::delete('/users/delete/{id}', [AdminController::class, 'destroy'])->name('admin.users.delete');

        // Settings (Simple View)
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    });

});