<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index', [
            'codeCard' => Auth::user()->codeCard,
        ]);
    }
}
