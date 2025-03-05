<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\SavingGoal;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // function pour appeler la vue dashboard 
     public function showDashboard(){
    
      $goals = SavingGoal::where('user_id', Auth::id())->orderBy('deadline', 'asc')->get(); // Récupérer les objectifs pour l'utilisateur connecté
      $transactions = Transaction::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
      $categories = Category::where('user_id', Auth::id())->get(); //Récupérer uniquement les catégories créées par l'utilisateur actuel.
      return view('dashboard',  compact('goals','transactions', 'categories'));


     }

    
}
