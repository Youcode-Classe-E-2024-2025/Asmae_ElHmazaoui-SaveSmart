<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // methode pour la création des catégories
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'categoryName' => 'required|string|max:255',
        ]);

        // Création de la catégorie
        Category::create([
            'name' => $request->categoryName,
            'user_id' => Auth::id(), // Associer la catégorie à l'utilisateur connecté
        ]);

        // Redirection avec un message de succès
        return redirect()->route('Dashboard')->with('success', 'Catégorie ajoutée avec succès.');
    }
}
