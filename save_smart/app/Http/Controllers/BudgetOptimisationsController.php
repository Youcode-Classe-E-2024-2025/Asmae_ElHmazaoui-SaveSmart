<?php

namespace App\Http\Controllers;

use App\Models\BudgetOptimisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetOptimisationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Affiche une liste des ressources
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Affiche le formulaire de création d'une nouvelle ressource
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valide et enregistre la nouvelle ressource
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetOptimisation  $budgetOptimisation
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetOptimisation $budgetOptimisation)
    {
        // Affiche une ressource spécifique
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BudgetOptimisation  $budgetOptimisation
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetOptimisation $budgetOptimisation)
    {
        // Affiche le formulaire d'édition d'une ressource
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetOptimisation  $budgetOptimisation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetOptimisation $budgetOptimisation)
    {
        // Valide et met à jour la ressourc
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetOptimisation  $budgetOptimisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetOptimisation $budgetOptimisation)
    {
        // Supprime la ressource
    }

    /**
     * Calcule le budget d'optimisation en utilisant la méthode 50/30/20.
     *
     * @param  float  $income  Le revenu mensuel de l'utilisateur.
     * @return array  Un tableau associatif contenant les montants alloués pour les besoins, les envies et l'épargne.
     */
    public function calculate503020Budget($income)
    {
        $needs = $income * 0.5; // 50% pour les besoins
        $wants = $income * 0.3; // 30% pour les envies
        $savings = $income * 0.2; // 20% pour l'épargne et les dettes

        return [
            'needs' => $needs,
            'wants' => $wants,
            'savings' => $savings,
        ];
    }

    /**
     * Affiche le formulaire pour calculer le budget avec la méthode 50/30/20.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCalculateForm()
    {
        return view('Dashboard'); // Assurez-vous que cette vue existe
    }

    /**
     * Traite la requête de calcul du budget avec la méthode 50/30/20.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request)
    {
        // Valider le revenu
        $request->validate([
            'income' => 'required|numeric|min:0',
        ]);

        // Récupérer le revenu de la requête
        $income = $request->input('income');

        // Calculer le budget
        $budget = $this->calculate503020Budget($income);

        // Passer le budget à la vue
        return view('Dashboard', compact('budget', 'income')); // Assurez-vous que cette vue existe
    }
}