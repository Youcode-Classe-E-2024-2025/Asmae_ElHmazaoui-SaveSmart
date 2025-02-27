<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // funstion pour appeler la vue dashboard 
     public function showDashboard(){
      return view('dashboard');
     }
}
