@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="container">
        <h1>Concentração de Gados por Hora</h1>
        <canvas id="predictionsChart" width="400" height="200"></canvas>
    </div>
    <div class="container">
        <!--
        <h1>Concentração de Gados Dias da Semana</h1>

        <canvas id="predictionsByDayChart" width="600" height="300"></canvas>
        -->
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var predictionsData = @json($predictionsByHour);

        var labels = predictionsData.map(prediction => prediction.hour + ":00");
        var values = predictionsData.map(prediction => prediction.totalPredictions);

        var ctx = document.getElementById('predictionsChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Pode ser 'line' para um gráfico de linha
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Gados encontrados',
                    data: values,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        var predictionsByDayData = @json($predictionsByDay);

        // Mapeia os valores do backend para os dias da semana em inglês
        var dayMapping = {
            'domingo': 'Sunday',
            'segunda-feira': 'Monday',
            'terça-feira': 'Tuesday',
            'quarta-feira': 'Wednesday',
            'quinta-feira': 'Thursday',
            'sexta-feira': 'Friday',
            'sábado': 'Saturday',
        };

        var labelsByDay = predictionsByDayData.map(prediction => {
            var day = prediction.day.toLowerCase();
            console.log("Dia original:", day, "Dia mapeado:", dayMapping[day]);
            return dayMapping[day];
        });
        var valuesByDay = predictionsByDayData.map(prediction => prediction.qtd);

        var ctxByDay = document.getElementById('predictionsByDayChart').getContext('2d');
        var myChartByDay = new Chart(ctxByDay, {
            type: 'bar',
            data: {
                labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                datasets: [{
                    label: 'Total de Previsões',
                    data: valuesByDay,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
