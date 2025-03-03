<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use App\Models\User;

class InvitationController extends Controller
{
    public function showInvitationForm()
    {
        return view('invite');
    }

    public function sendInvitation(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        // Générer un lien d'invitation (peut être un token ou une route spéciale)
        $invitationLink = url('/register?email=' . urlencode($request->email));

        // Envoyer l'email
        Mail::to($request->email)->send(new InvitationMail($invitationLink));

        return back()->with('success', 'Invitation envoyée avec succès !');
    }
}
