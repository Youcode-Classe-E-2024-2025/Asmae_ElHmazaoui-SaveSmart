<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\SavingGoal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        return view('dashboard', compact('goals', 'transactions', 'categories', 'monthlyExpenses', 'monthlyIncomes', 'year', 'availableYears'));
    }

    private function getMonthlyTransactions($year, $type)
    {
        // Récupérer les transactions du type donné (Expense ou Income)
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('type', $type)
            ->whereRaw("EXTRACT(YEAR FROM date) = ?", [$year])
            ->get()
            ->groupBy(function ($transaction) {
                return Carbon::parse($transaction->date)->format('m'); // Mois au format numérique "01", "02"...
            });

        // Initialiser un tableau avec 12 mois à 0€
        $monthlyData = array_fill_keys(range(1, 12), 0);

        // Ajouter les montants aux mois correspondants
        foreach ($transactions as $month => $items) {
            $monthlyData[intval($month)] = $items->sum('amount');
        }

        return $monthlyData;
    }
}
