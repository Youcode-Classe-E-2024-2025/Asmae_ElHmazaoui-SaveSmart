<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\SavingGoal;
use App\Models\User;
use App\Models\FamilyAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Invitation;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        $goals = SavingGoal::where('user_id', Auth::id())->orderBy('deadline', 'asc')->get();
        $transactions = Transaction::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        $categories = Category::where('user_id', Auth::id())->get();

        // Récupérer l'année sélectionnée (ou l'année actuelle par défaut)
        $year = $request->input('year', date('Y'));

        // Récupérer les années disponibles (distinctes)
        $availableYears = Transaction::where('user_id', Auth::id())
            ->selectRaw("DISTINCT EXTRACT(YEAR FROM date) AS year")
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Récupérer les statistiques pour les graphiques
        $monthlyExpenses = $this->getMonthlyTransactions($year, 'Expense');
        $monthlyIncomes = $this->getMonthlyTransactions($year, 'Income');

        // Récupérer tous les membres de la famille
        $familyMembers = [];
        if (Auth::user()->familyAccount) {
            $familyMembers = User::where('family_account_id', Auth::user()->familyAccount->id)->get();
        }

        // Récupérer les membres de la famille INVITÉS par l'utilisateur
        $invitedFamilyMembers = [];
        if (Auth::user()->familyAccount) {
            // Récupérer les invitations faites par l'utilisateur pour ce compte familial
            $invitations = Invitation::where('family_account_id', Auth::user()->familyAccount->id)
                                        ->where('invited_by', Auth::id())
                                        ->whereNotNull('invited_id') // Seulement ceux qui ont accepté l'invitation
                                        ->get();

            // Récupérer les utilisateurs correspondant à ces invitations
            $invitedFamilyMembers = User::whereIn('id', $invitations->pluck('invited_id'))->get();
        }

        $showInvited = $request->session()->get('showInvited', false);
        $request->session()->forget('showInvited'); // Clear the session

        return view('dashboard', compact('goals', 'transactions', 'categories', 'monthlyExpenses', 'monthlyIncomes', 'year', 'availableYears', 'familyMembers','invitedFamilyMembers', 'showInvited')); // IMPORTANT : 'invitedFamilyMembers'
    }

    private function getMonthlyTransactions($year, $type)
    {
        // Récupérer les transactions du type donné (Expense ou Income)
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('type', $type)
            ->whereRaw("EXTRACT(YEAR FROM date) = ?", [$year])
            ->get()
            ->groupBy(function ($transaction) {
                return Carbon::parse($transaction->date)->format('m');
            });

        // Initialiser un tableau avec 12 mois à 0€
        $monthlyData = array_fill_keys(range(1, 12), 0);

        // Ajouter les montants aux mois correspondants
        foreach ($transactions as $month => $items) {
            $monthlyData[intval($month)] = $items->sum('amount');
        }

        return $monthlyData;
    }

    public function acceptInvitation(Request $request, $token)
    {
        Log::info('Accept Invitation: Token='.$token); // Ajoute cette ligne

        // Rechercher l'invitation par token
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation) {
            Log::error('Invitation not found for token: ' . $token); // Ajoute cette ligne
            return redirect()->route('login')->with('error', 'L\'invitation est invalide.');
        }

         Log::info('Invitation found: ' . json_encode($invitation->toArray())); // Ajoute cette ligne


        // Récupérer l'ID du compte familial et de l'inviteur
        $familyAccountId = $invitation->family_account_id;
        $invitedByUserId = $invitation->invited_by;

        // Récupérer le compte familial et l'inviteur
        $familyAccount = FamilyAccount::find($familyAccountId);
        $invitedByUser = User::find($invitedByUserId);

        // Vérifier si le compte familial et l'inviteur existent
        if (!$familyAccount || !$invitedByUser) {
            Log::error('Family account or invited user not found.'); // Ajoute cette ligne
            return redirect()->route('login')->with('error', 'Le compte familial ou l\'inviteur n\'existe pas.');
        }

        // Si l'utilisateur est déjà connecté
        if (Auth::check()) {
            $user = Auth::user();

             Log::info('User connecté : ' . json_encode($user->toArray())); // Ajoute cette ligne

            // Vérifier si l'utilisateur a déjà un compte familial
            if ($user->family_account_id) {
                Log::warning('User already has a family account.'); // Ajoute cette ligne
                return redirect()->route('FamilyAccount.index')->with('error', 'Vous avez déjà un compte familial.');
            }

            // Associer l'utilisateur au compte familial
            $user->family_account_id = $familyAccountId;
            $user->save();
             Log::info('User family account ID updated.'); // Ajoute cette ligne


            // Modifier l'invitation pour enregistrer l'ID de l'utilisateur qui a accepté
            $invitation->invited_id = $user->id;
             Log::info('Invitation invited_id before save: ' . $invitation->invited_id); // Ajoute cette ligne
            $invitation->save();
             Log::info('Invitation invited_id after save: ' . $invitation->invited_id); // Ajoute cette ligne

            // Supprimer l'invitation après utilisation
            $invitation->delete();
             Log::info('Invitation deleted.'); // Ajoute cette ligne


            // Redirige vers le tableau de bord, en indiquant qu'on doit afficher les membres invités
            return redirect()->route('Dashboard')->with('showInvited', true)->with('success', 'Vous avez rejoint le compte familial de ' . $invitedByUser->name . ' !');
        } else {
            // ...
        }
    }
}