@extends('layouts/layoutMaster')

@section('title', 'Detalles del Paciente')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}" />
@endsection

@section('content')
    <div class="container">
        <h1>Detalles del Paciente</h1>
        <a href="{{ route('paciente.index') }}" class="btn btn-secondary mb-3">Volver</a>

        <div class="card mb-4">
            <div class="user-profile-header-banner">
                <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top">
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4>{{ $paciente->nombre }} {{ $paciente->apellido }}</h4>
                            <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item">
                                    <i class='mdi mdi-calendar-blank-outline me-1 mdi-20px'></i><span class="fw-medium">Fecha de Nacimiento: {{ $paciente->fecha_nacimiento }}</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class='mdi mdi-map-marker-outline me-1 mdi-20px'></i><span class="fw-medium">RUT: {{ $paciente->rut }}</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class='mdi mdi-gender-female me-1 mdi-20px'></i><span class="fw-medium">{{ $paciente->sexo == 1 ? 'Femenino' : 'Masculino' }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="user-profile-info">
                            <h5>Previsión</h5>
                            <p>{{ $paciente->previsionConvenio->convenio ?? 'Sin convenio' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- Recuadro de Citas -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Historial de Citas</h5>
            </div>
            <div class="card-body">
                @if($citas->isEmpty())
                    <p>No tiene citas registradas.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sucursal</th>
                                <th>Especialidad</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citas as $cita)
                                <tr>
                                    <tr>
                                        <td>{{ $cita->sucursal_id}}</td>
                                        <td>{{ $cita->title }}</td>
                                        <td>{{ $cita->start }}</td>
                                        <td>{{ $cita->estado }}</td>
                                        <td>{{ $cita->box_ID }}</td>
                                    </tr>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>    
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-user-view-account.js') }}"></script>
@endsection


