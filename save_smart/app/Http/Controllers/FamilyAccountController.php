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

    public function update(Request $request, $id)
    {
        // Récupère le compte familial de l'utilisateur
        $familyAccount = $request->user()->familyAccount;
        if (!$familyAccount || $familyAccount->id != $id) {
            abort(403, 'Accès non autorisé.');
        }

        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Traitement d'un nouvel avatar
        if ($request->hasFile('avatar')) {
            if ($familyAccount->avatar) {
                Storage::disk('public')->delete($familyAccount->avatar);
            }
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Mise à jour du compte familial
        $familyAccount->update($validatedData);

        return redirect()->route('FamilyAccount.index')
            ->with('success', 'Compte familial mis à jour avec succès.');
    }

    
    public function destroy(Request $request, $id)
    {
        // Récupère le compte familial de l'utilisateur
        $familyAccount = $request->user()->familyAccount;
        if (!$familyAccount || $familyAccount->id != $id) {
            abort(403, 'Accès non autorisé.');
        }

        // Suppression du fichier avatar s'il existe
        if ($familyAccount->avatar) {
            Storage::disk('public')->delete($familyAccount->avatar);
        }

        // Supprime le compte familial
        $familyAccount->delete();

        // Mettre à jour l'utilisateur en supprimant l'association
        $user = $request->user();
        $user->family_account_id = null;
        $user->save();

        return redirect()->route('FamilyAccount.index')
            ->with('success', 'Compte familial supprimé avec succès.');
    }
}