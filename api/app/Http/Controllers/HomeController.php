<?php

namespace App\Http\Controllers;

use App\Models\Predictions;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $predictions = Predictions::where('user_id', $user->id)->get();

        return view('dashboard', $predictions);
    }
}
