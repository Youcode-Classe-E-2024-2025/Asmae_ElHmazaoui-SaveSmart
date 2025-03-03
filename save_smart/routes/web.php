<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FamilyAccountController;
use App\Http\Controllers\InvitationController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Dashboard
Route::get('/Dashboard', [DashboardController::class, 'showDashboard'])->name('Dashboard');

// Auth routes
Route::get('/signup', [AuthController::class, 'showSignUp']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/signup', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout']);

// category routes
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// transactions routes
Route::middleware(['auth'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});

// FamilyAccount routes
Route::get('/FamilyAccount', [FamilyAccountController::class, 'index'])->name('FamilyAccount.index');
Route::post('/FamilyAccount', [FamilyAccountController::class, 'store'])->name('FamilyAccount.store'); 
Route::get('/FamilyAccount/{id}/edit', [FamilyAccountController::class, 'edit'])->name('FamilyAccount.edit'); 
Route::put('/FamilyAccount/{id}', [FamilyAccountController::class, 'update'])->name('FamilyAccount.update'); 
Route::delete('/FamilyAccount/{id}', [FamilyAccountController::class, 'destroy'])->name('FamilyAccount.destroy');


Route::get('/invite', [InvitationController::class, 'showInvitationForm'])->name('invite.form');
Route::post('/invite', [InvitationController::class, 'sendInvitation'])->name('send.invitation');
