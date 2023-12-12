@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="container">
        <h1>Concentração de Gados por Hora</h1>
        <canvas id="predictionsChart" width="400" height="200"></canvas>
    </div>
    <br>
    <div class="container">
        <h1>Concentração de Gados Dias da Semana</h1>
        <canvas id="predictionsByDayChart" width="400" height="200"></canvas>
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
            type: 'bar',
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

        var diasDaSemana = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        var labelsByDay = diasDaSemana.map(day => predictionsByDayData[day] ? day : '');
        var valuesByDay = diasDaSemana.map(day => predictionsByDayData[day] ? predictionsByDayData[day].max_qtd : 0);

        var ctxByDay = document.getElementById('predictionsByDayChart').getContext('2d');
        var myChartByDay = new Chart(ctxByDay, {
            type: 'bar',
            data: {
                labels: labelsByDay,
                datasets: [{
                    label: 'Máximo de Previsões',
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
