<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    //methode pour rediriger l'uitlisateur vers la page d'inscription
    public function showSignUp(){
        return view('signup');
    }
    //methode pour rediriger l'uitlisateur vers la page de connexion
    public function showLogin(){
        return view('login');
    }
    //methode pour l'inscription

    //methode pour la connexion

    //methode pour la deconnexion

}
