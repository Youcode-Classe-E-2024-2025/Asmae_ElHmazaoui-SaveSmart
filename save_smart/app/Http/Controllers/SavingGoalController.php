<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavingGoal;
use Illuminate\Support\Facades\Auth;

class SavingGoalController extends Controller
{
    // Methode pour l'affichage des objectifs d'épargne
    public function index()
    {
        $goals = SavingGoal::where('user_id', Auth::id())->orderBy('deadline', 'asc')->get(); // Récupérer les objectifs pour l'utilisateur connecté
        return view('Dashboard', compact('goals')); // Afficher les objectifs sur le tableau de bord
    }

    // Methode pour la création des objectifs d'épargne
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'goal_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date',
        ]);

        // Créer un nouvel objectif d'épargne
        SavingGoal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'goal_amount' => $request->goal_amount,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('Dashboard')->with('success', 'Objectif d\'épargne ajouté avec succès.');
    }

   

}
