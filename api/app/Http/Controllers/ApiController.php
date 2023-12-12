<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\Predictions;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function handlePost(Request $request)
    {
        $request->validate([
            'quantity' => 'required',
            'local' => 'required',
            'user_email' => 'required'
        ]);

        $user = User::where('email', $request['user_email'])->first();

        if (!isset($user)){
            return response()->json(['message' => 'No user found with this email!'], 404);
        }

        $prediction = Prediction::create([
            'quantity' => $request['quantity'],
            'local' =>  $request['local'],
            'user_id' => $user->id
        ]);

        return response()->json(['message' => 'Predicion storage successfully!']);
    }

    public function handlePostTest(Request $request)
    {
        $request->validate([
            'teste' => 'required'
        ]);

        echo($request['teste']);

        return response()->json(['message' => 'deu tudo certo']);
    }
}
