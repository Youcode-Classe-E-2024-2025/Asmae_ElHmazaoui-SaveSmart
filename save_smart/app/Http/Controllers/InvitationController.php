<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\FamilyAccount;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function showInvitationForm()
    {
        // ...
    }

    public function sendInvitation(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
        ]);

        $familyAccount = Auth::user()->familyAccount;

        if (!$familyAccount) {
            return back()->with('error', 'Vous devez d\'abord créer un compte familial pour inviter des utilisateurs.');
        }

        // Vérifier si l'adresse e-mail existe déjà dans la table users
        $existingUser = User::where('email', $request->email)->first();

        // Générer un token unique
        $token = Str::uuid();

        $invitedId = null;
        if ($existingUser) {
           $invitedId = $existingUser->id;
        }

        // Créer l'invitation
        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'family_account_id' => $familyAccount->id,
            'invited_by' => Auth::id(),
            'invited_id' => $invitedId, // Enregistre l'ID de l'utilisateur invité (s'il existe)
        ]);

        // Créer le lien d'invitation
        $invitationLink = route('invitation.accept', ['token' => $token]);

        // Envoyer l'email
        Mail::to($request->email)->send(new InvitationMail($invitationLink));

        return back()->with('success', 'Invitation envoyée avec succès !');
    }

    public function acceptInvitation(Request $request, $token)
    {
        // Rechercher l'invitation par token
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation) {
            return redirect()->route('login')->with('error', 'L\'invitation est invalide.');
        }

        // Récupérer l'ID du compte familial et de l'inviteur
        $familyAccountId = $invitation->family_account_id;
        $invitedByUserId = $invitation->invited_by;

        // Récupérer le compte familial et l'inviteur
        $familyAccount = FamilyAccount::find($familyAccountId);
        $invitedByUser = User::find($invitedByUserId);

        // Vérifier si le compte familial et l'inviteur existent
        if (!$familyAccount || !$invitedByUser) {
            return redirect()->route('login')->with('error', 'Le compte familial ou l\'inviteur n\'existe pas.');
        }

        // Si l'utilisateur est déjà connecté
        if (Auth::check()) {
            $user = Auth::user();

            // Vérifier si l'utilisateur a déjà un compte familial
            if ($user->family_account_id) {
                return redirect()->route('FamilyAccount.index')->with('error', 'Vous avez déjà un compte familial.');
            }

            // Associer l'utilisateur au compte familial
            $user->family_account_id = $familyAccountId;
            $user->save();

            // Modifier l'invitation pour enregistrer l'ID de l'utilisateur qui a accepté
            $invitation->invited_id = $user->id;
            $invitation->save();

            // Supprimer l'invitation après utilisation
            $invitation->delete();

            // Redirige vers le tableau de bord, en indiquant qu'on doit afficher les membres invités
            return redirect()->route('Dashboard')->with('showInvited', true)->with('success', 'Vous avez rejoint le compte familial de ' . $invitedByUser->name . ' !');
        } else {
            // ...
        }
    }
}