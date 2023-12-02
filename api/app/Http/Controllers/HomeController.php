<?php

namespace App\Http\Controllers;

use App\Models\Predictions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //$predictions = Predictions::where('user_id', $user->id)->get();
        $predictionsByHour = DB::table('predictions')
            ->select(
                DB::raw("CAST(strftime('%H', created_at) AS INTEGER) as hour"),
                DB::raw('COUNT(*) as totalPredictions')
            )
            ->where('user_id', $user->id)
            ->whereBetween(DB::raw("CAST(strftime('%H', created_at) AS INTEGER)"), [6, 18]) // Filtra as horas entre 6 e 18
            ->groupBy(DB::raw("CAST(strftime('%H', created_at) AS INTEGER)"))
            ->get();

        //dd($predictionsByHour);

        return view('dashboard', ['predictionsByHour' => $predictionsByHour, 'predictionsByDay' => $this->predictionsByDay($user)]);

    }

    private function predictionsByDay($user)
    {
    // Obtém a data de 7 dias atrás
        $dataSeteDiasAtras = Carbon::now()->subDays(7)->toDateString();

        $predictions = Predictions::where('user_id', $user->id)
            ->where('created_at', '>=', $dataSeteDiasAtras)
            ->get();

        $data = [];

        foreach ($predictions as $prediction) {
            $dataFormatada = Carbon::parse($prediction->created_at);
            $diaDaSemana = $dataFormatada->format('l');

            // Verifica se já existe um registro para o dia da semana atual
            if (isset($data[$diaDaSemana])) {
                // Se já existir, adicionar a quantidade ao valor existente
                $data[$diaDaSemana]['qtd'] += $prediction->quantity;
            } else {
                // Se não existir, criar um novo registro para o dia da semana
                $data[$diaDaSemana] = [
                    'qtd' => $prediction->quantity
                ];
            }
        }

        //dd($data);

        return $data;
    }
}
