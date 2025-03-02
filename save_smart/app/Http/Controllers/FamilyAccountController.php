<?php

namespace App\Http\Controllers;

use App\Models\FamilyAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FamilyAccountController extends Controller
{
    
    public function index(Request $request)
    {
        $familyAccount = $request->user()->familyAccount;

        return view('profile', compact('familyAccount'));
    }

    public function store(Request $request)
    {
        // Vérifier si l'utilisateur a déjà un compte familial
        if ($request->user()->familyAccount) {
            return redirect()->back()->with('error', 'Vous possédez déjà un compte familial.');
        }

        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Stockage de l'avatar s'il est fourni
        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Création du compte familial
        $familyAccount = FamilyAccount::create($validatedData);

        // Associer l'utilisateur authentifié à ce compte familial
        $user = $request->user();
        $user->family_account_id = $familyAccount->id;
        $user->save();

        return redirect()->route('FamilyAccount.index')
            ->with('success', 'Compte familial créé avec succès.');
    }

  
    public function edit(Request $request, $id)
    {
        $familyAccount = $request->user()->familyAccount;

        if (!$familyAccount || $familyAccount->id != $id) {
            abort(403, 'Accès non autorisé.');
        }

        return view('profile', compact('familyAccount')); // Réutiliser la vue 'profile' et adapter le modal
    }

   
}