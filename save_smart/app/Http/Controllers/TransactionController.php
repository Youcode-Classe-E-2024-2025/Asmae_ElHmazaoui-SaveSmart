<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // methodes pour l'affichage des transactions
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        $categories = Category::where('user_id', Auth::id())->get(); // Filtrer par utilisateur
        return view('Dashboard', compact('transactions', 'categories'));
    }

    // methodes pour la création des transactions
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Income,Expense',
            'categoryId' => 'required|exists:categories,id', // Corrected field name
            'date' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'category_id' => $request->categoryId,  // Corrected field name
            'amount' => $request->amount,
            'type' => $request->type,
            'date' => $request->date,
        ]);

        // Re-fetch the transactions and categories to include the new transaction
        $transactions = Transaction::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        $categories = Category::all();

        return view('Dashboard', compact('transactions', 'categories')); // Pass transactions and categories to the view.
    }

    // methodes pour la modification des transactions
    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Income,Expense',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
        ]);

        $transaction->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'date' => $request->date,
        ]);

        return view('Dashboard', compact('transactions', 'categories'));
    }


    // public function destroy($id)
    // {
    //     $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    //     $transaction->delete();

    //     return view('Dashboard', compact('transactions', 'categories'));
    // }
}