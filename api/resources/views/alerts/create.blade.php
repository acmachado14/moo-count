@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <style>
        .custom-select {
            color: #95B963; /* Cor do texto (preto) */
            /* Outros estilos, se necessário */
        }
    </style>
    <div class="container">
        <h2>Cadastrar Alerta</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('alert.store') }}" method="post">
            @csrf
            <label for="frequency">Frequência:</label>
            <select name="frequency" id="frequency" class="custom-select" required>
                <option value="daily">Diário</option>
                <option value="weekly">Semanal</option>
                <option value="monthly">Mensal</option>
            </select>
            <br>
            <label for="quantity_cattle">Quantidade de Gado:</label>
            <input type="number" name="quantity_cattle" id="quantity_cattle" class="form-control" required>
            <br>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
        <br>
        <h2>Lista de Alertas</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Frequência</th>
                <th>Quantidade de Gado</th>
            </tr>
            </thead>
            <tbody>
            @foreach($userAlerts as $alert)
                <tr>
                    <td>{{ $alert->frequency }}</td>
                    <td>{{ $alert->quantity_cattle }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
