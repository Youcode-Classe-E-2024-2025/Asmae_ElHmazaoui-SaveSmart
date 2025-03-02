<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    //methode pour rediriger l'uitlisateur vers la page d'inscription
    public function showSignUp()
    {
        return view('signup');
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

            return redirect()->route('FamilyAccount.index')->with('success', 'Connexion réussie.');
        }

        return back()->withErrors([ // Retourne à la page précédente avec les erreurs
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

   
}