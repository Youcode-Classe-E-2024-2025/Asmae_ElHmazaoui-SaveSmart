<?php

namespace App\Http\Controllers;

use App\Models\FamilyAccount;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //methode pour rediriger l'uitlisateur vers la page d'inscription
    public function showSignUp(Request $request)
    {
        $email = $request->query('email'); // Récupérer l'email de l'URL
        return view('signup', ['email' => $email]); // Passer l'email à la vue
    }

    //methode pour rediriger l'uitlisateur vers la page de connexion
    public function showLogin()
    {
        return view('login');
    }

    //methode pour l'inscription
    public function register(Request $request)
    {
        // validation des champs
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); // Connexion automatique après l'inscription

        // Régénérer la session après l'authentification
        $request->session()->regenerate();

        // Récupérer le token d'invitation de la session
        $invitationToken = session('invitation_token');

        if ($invitationToken) {
            // Rechercher l'invitation par token
            $invitation = Invitation::where('token', $invitationToken)->first();

            if ($invitation) {
                // Associer l'utilisateur au compte familial
                $user->family_account_id = $invitation->family_account_id;
                $user->save();

                // Récupérer l'inviteur
                $invitedByUser = User::find($invitation->invited_by);

                // Supprimer l'invitation après utilisation
                $invitation->delete();

                // Supprimer le token de la session
                session()->forget('invitation_token');

                // Rediriger vers le profil de l'inviteur
                return redirect()->route('FamilyAccount.index')->with('success', 'Inscription réussie et compte familial rejoint ! Bienvenue dans le compte familial de ' . $invitedByUser->name . '.');
            }
        }

        // Si pas d'invitation, redirection par défaut
        return redirect()->route('FamilyAccount.index')->with('success', 'Inscription réussie. Veuillez créer votre compte familial.');
    }


    //methode pour la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Récupérer le token d'invitation de la session
            $invitationToken = session('invitation_token');

            if ($invitationToken) {
                // Rechercher l'invitation par token
                $invitation = Invitation::where('token', $invitationToken)->first();

                if ($invitation) {
                    // Associer l'utilisateur au compte familial
                    $user = Auth::user();
                    $user->family_account_id = $invitation->family_account_id;
                    $user->save();

                    // Récupérer l'inviteur
                    $invitedByUser = User::find($invitation->invited_by);

                    // Supprimer l'invitation après utilisation
                    $invitation->delete();

                    // Supprimer le token de la session
                    session()->forget('invitation_token');

                    // Rediriger vers le profil de l'inviteur
                    return redirect()->route('FamilyAccount.index')->with('success', 'Connexion réussie et compte familial rejoint ! Bienvenue dans le compte familial de ' . $invitedByUser->name . '.');
                }
            }

            return redirect()->route('FamilyAccount.index')->with('success', 'Connexion réussie.');
        }

        return back()->withErrors([ // Retourne à la page précédente avec les erreurs
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    //methode pour la deconnexion
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }
}