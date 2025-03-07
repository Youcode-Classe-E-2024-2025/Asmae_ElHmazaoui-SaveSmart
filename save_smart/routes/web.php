<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FamilyAccountController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SavingGoalController;
use App\Http\Controllers\BudgetOptimisationsController;
Route::get('/', function () {
    return view('welcome');
});

// Auth Dashboard
Route::get('/Dashboard', [DashboardController::class, 'showDashboard'])->name('Dashboard');


// Routes d'authentification
Route::get('/register', [AuthController::class, 'showSignUp'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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


// Route::get('/invite', [InvitationController::class, 'showInvitationForm'])->name('invite.form');
// Route::post('/invite', [InvitationController::class, 'sendInvitation'])->name('send.invitation');

// Routes d'invitation
Route::get('/invite', [InvitationController::class, 'showInvitationForm'])->name('invitation.form');
Route::post('/invite', [InvitationController::class, 'sendInvitation'])->name('invitation.send');
Route::get('/accept-invitation/{token}', [InvitationController::class, 'acceptInvitation'])->name('invitation.accept');


// Saving Goals routes (Objectifs d'épargne)
Route::middleware(['auth'])->group(function () {
    Route::get('/saving-goals', [SavingGoalController::class, 'index'])->name('savingGoals.index');
    Route::post('/saving-goals', [SavingGoalController::class, 'store'])->name('savingGoals.store');
    Route::get('/saving-goals/{savingGoal}', [SavingGoalController::class, 'show'])->name('savingGoals.show');
    Route::put('/saving-goals/{savingGoal}', [SavingGoalController::class, 'update'])->name('savingGoals.update');
    Route::delete('/saving-goals/{savingGoal}', [SavingGoalController::class, 'destroy'])->name('savingGoals.destroy');
});

// Routes de budget
Route::get('budget-optimisations/calculate', [BudgetOptimisationsController::class, 'showCalculateForm'])->name('budget-optimisations.calculate-form');
Route::post('budget-optimisations/calculate', [BudgetOptimisationsController::class, 'calculate'])->name('budget-optimisations.calculate');
Route::resource('budget-optimisations', BudgetOptimisationsController::class);