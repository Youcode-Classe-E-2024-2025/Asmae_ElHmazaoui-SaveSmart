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

 
}