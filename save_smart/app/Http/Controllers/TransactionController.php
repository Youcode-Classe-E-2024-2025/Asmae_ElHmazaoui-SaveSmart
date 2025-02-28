<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // methode pour l'affichage des transactions
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        $categories = Category::where('user_id', Auth::id())->get(); // Filtrer par utilisateur
        return view('Dashboard', compact('transactions', 'categories'));
    }

    
}