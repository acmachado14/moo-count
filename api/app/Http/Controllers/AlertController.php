<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertConfiguration;

class AlertController extends Controller
{
    public function create()
    {
        $userAlerts = AlertConfiguration::where('user_id', auth()->user()->id)->get();

        return view('alerts.create', compact('userAlerts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly',
            'quantity_cattle' => 'required|integer',
        ]);

        AlertConfiguration::create([
            'user_id' => auth()->user()->id,
            'frequency' => $request->frequency,
            'quantity_cattle' => $request->quantity_cattle,
        ]);

        return redirect()->route('alert.create')->with('success', 'Alerta cadastrado com sucesso!');
    }
}
