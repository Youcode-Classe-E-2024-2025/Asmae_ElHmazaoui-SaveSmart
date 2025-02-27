<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // function pour appeler la vue dashboard 
     public function showDashboard(){
     
      $categories = Category::where('user_id', Auth::id())->get(); //Récupérer uniquement les catégories créées par l'utilisateur actuel.
      return view('dashboard', compact('categories'));


     }

    
}
