<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
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
        $currentDate = Carbon::now()->format('Y-m-d');

        $predictionsByHour = DB::table('predictions')
            ->select(
                DB::raw("CAST(strftime('%H', created_at) AS INTEGER) as hour"),
                DB::raw('MAX(quantity) as totalPredictions')
            )
            ->where('user_id', $user->id)
            ->whereBetween(DB::raw("CAST(strftime('%H', created_at) AS INTEGER)"), [6, 18]) // Filtra as horas entre 6 e 18
            ->whereDate('created_at', $currentDate) // Filtra pela data atual
            ->groupBy(DB::raw("CAST(strftime('%H', created_at) AS INTEGER)"))
            ->get();

        return view('dashboard', ['predictionsByHour' => $predictionsByHour, 'predictionsByDay' => $this->predictionsByDay($user)]);
    }

    private function predictionsByDay($user)
    {
        $dataSeteDiasAtras = Carbon::now()->subDays(7);

        $predictions = Prediction::where('user_id', $user->id)
            ->where('created_at', '>=', $dataSeteDiasAtras)
            ->get();

        $data = [];

        // Array de dias da semana
        $diasDaSemana = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Inicializa os valores máximos como 0 para cada dia da semana
        foreach ($diasDaSemana as $dia) {
            $data[$dia] = [
                'max_qtd' => 0
            ];
        }

        foreach ($predictions as $prediction) {
            $dataFormatada = Carbon::parse($prediction->created_at);
            $diaDaSemana = $dataFormatada->format('l');

            // Atualiza o valor máximo se a quantidade atual for maior
            if ($prediction->quantity > $data[$diaDaSemana]['max_qtd']) {
                $data[$diaDaSemana]['max_qtd'] = $prediction->quantity;
            }
        }

        return $data;
    }
}
