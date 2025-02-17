@extends('layouts/layoutMaster')

@section('vendor-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container mt-4">
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('examenes.index') }}">Agenda de atenciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('examenes.procesamiento') }}">Procesamiento de
                    exámenes</a>
            </li>
        </ul>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2">

                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('examenes.index', ['date' => $date->copy()->subDay()->format('Y-m-d')]) }}"
                            class="btn btn-outline-secondary">&lt;</a>
                        <h4 class="mb-0 mx-3">{{ $date->format('l d F Y') }}</h4>
                        <a href="{{ route('examenes.index', ['date' => $date->copy()->addDay()->format('Y-m-d')]) }}"
                            class="btn btn-outline-secondary">&gt;</a>
                    </div>
                </div>
                <select class="form-select" name="professional" id="professional">
                    <option value="">Todos los Profesionales</option>
                    @foreach ($medicos as $medico)
                        <option value="{{ $medico->id }}">{{ $medico->nombre }}</option>
                    @endforeach
                </select>

                <select class="form-select" name="resource" id="resource">
                    <option value="">Filtrar por Recurso</option>
                    <!-- Add resources as needed -->
                </select>

                <button class="btn btn-success" onclick="window.location='{{ route('examenes.create') }}'">+ Nueva
                    atención</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Paciente</th>
                        <th>Profesional/Recurso</th>
                        <th>Examen</th>
                        <th>Resultado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="examenes-table-body">
                    @foreach ($examenes as $examen)
                        <tr>
                            <td>{{ $examen->codigo }}</td>
                            <td>{{ $examen->nombre }}</td>
                            <td>{{ $examen->profesional }}</td>
                            <td>{{ $examen->examen }}</td>
                            <td>{{ $examen->resultado }}</td>
                            <td>{{ $examen->fecha }}</td>
                            <td>
                                <!-- Aquí puedes agregar botones de acción, como editar o eliminar -->
                                <button class="btn btn-danger">Botón</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('professional').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('professional_id', this.value);
        window.location = url;
    });

    document.getElementById('resource').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('resource', this.value);
        window.location = url;
    });
</script>
