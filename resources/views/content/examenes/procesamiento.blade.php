@extends('layouts/layoutMaster')

@section('vendor-style')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('content')
    <div class="container mt-4">
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('examenes.index') }}">Agenda de atenciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('examenes.procesamiento') }}">Procesamiento de
                    exámenes</a>
            </li>
        </ul>

        <!-- Filters -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="row mb-4">
                <div class="col-md-3">
                    <select class="form-select" name="status" id="status">
                        <option value="">En proceso</option>
                        <option value="completed">Completado</option>
                        <option value="cancelled">Anulado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="service" id="service">
                        <option value="">Todas las prestaciones</option>
                        <!-- Add your services here -->
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar por nombre..." id="search">
                        <button class="btn btn-success" type="button" onclick="applyFilters()">Buscar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Paciente</th>
                        <th>Profesional/Recurso</th>
                        <th>Fecha De Atención</th>
                        <th>Exámenes</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalles as $examen)
                        <tr>
                            <td>{{ $examen['id'] }}</td>
                            <td>{{ $examen['paciente'] }}</td>
                            <td>{{ $examen['profesional'] }}</td>
                            <td>{{ $examen['fecha'] }}</td>
                            <td>
                                @foreach ($examen['examenes'] as $detalle)
                                    <div><i class="material-icons tiny green-text">check_circle</i> {{ $detalle['codigo'] }}
                                        {{ $detalle['nombre'] }}</div>
                                @endforeach
                            </td>
                            <td>
                                <span class="badge blue white-text">{{ ucfirst($examen['estado']) }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
