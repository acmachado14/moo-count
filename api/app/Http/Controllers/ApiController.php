<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function handlePost(Request $request)
    {
        $postData = $request->all();
        // ou $postData = $request->input(); dependendo da sua preferência
        // Faça o que precisar com os dados postados, por exemplo, salvar no banco de dados ou processar.

        // Responder com uma mensagem simples
        return response()->json(['message' => 'POST data received successfully!']);
    }
}
