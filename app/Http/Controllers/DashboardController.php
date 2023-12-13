<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // OPTION 1: IMPLEMENT AUTH MIDDLEWARE INSIDE CONTROLLER
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('dashboard');
    }
}
