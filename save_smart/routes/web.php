<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Dashboard', [DashboardController::class, 'showDashboard'])->name('Dashboard');


// Auth routes
Route::get('/signup', [AuthController::class, 'showSignUp']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/signup', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout']);

// category routes
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// transactions routes
// Route::middleware(['auth'])->group(function () {
//     Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
//     Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
//     Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
//     Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
// });