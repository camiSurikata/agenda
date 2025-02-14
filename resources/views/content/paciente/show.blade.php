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

        <div class="card mb-4" >
            <div class="user-profile-header-banner">
                <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top">
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <img src="{{ asset('assets/img/avatars/' . $paciente->idpaciente . '.png') }}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
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
                                <th>Box</th>
                                <th>Desglose de la Cita</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citas as $cita)
                                <tr>
                                    <tr>
                                        <td>{{ $cita->sucursal->nombre ?? 'Sucursal no encontrada' }}</td>
                                        <td>{{ $cita->title }}</td>
                                        <td>{{ $cita->start }}</td>
                                        <td>
                                            @if ($cita->estado == 1)
                                                <span class="badge rounded-pill bg-label-danger">Atendiendose</span>
                                            @elseif($cita->estado == 2)
                                                <span class="badge rounded-pill bg-label-primary">Atendido</span>
                                            @elseif($cita->estado == 3)
                                                <span class="badge rounded-pill bg-label-warning">No Asiste</span>
                                            @elseif($cita->estado == 4)
                                                <span class="badge rounded-pill bg-label-success">Confirmado</span>
                                            @elseif($cita->estado == 5)
                                                <span class="badge rounded-pill bg-label-info">Espera</span>
                                            @endif
                                        </td>
                                        <td>{{ $cita->box->nombre ?? 'No asignado' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#detalleCita{{ $cita->id }}" aria-expanded="false">
                                                Ver detalles
                                            </button>
                                        </td>
                                    </tr>
                                </tr>
                                <!-- Fila oculta con los detalles -->
                                <tr id="detalleCita{{ $cita->id }}" class="collapse">
                                    <td colspan="6">
                                        <div class="p-3 border rounded">
                                            <strong>Médico Tratante: </strong> 
                                            <div class="d-flex flex-column ">
                                                <!-- Imagen del médico -->
                                                @if($cita->medico && $cita->medico->id)
                                                    <img src="{{ asset('assets/img/avatars/' . $cita->medico->id . '.png') }}" alt="Foto del médico" class="circle responsive-img" width="200" height="200">
                                                @else
                                                    <img src="{{ asset('assets/img/avatars/default.png') }}" alt="Foto del médico" class="circle responsive-img" width="80" height="80">
                                                @endif
                                                <!-- Nombre del médico debajo de la imagen -->
                                                <span class="fw-medium mt-2"> <strong>Nombre:</strong> {{ $cita->medico->nombre ?? 'No registrado' }}</span>
                                            </div>
                                        
                                            <!-- Información adicional del médico -->
                                            <strong>Especialidad: </strong> {{ $cita->medico->especialidad ?? 'No registrada' }} <br>
                                            <strong>Teléfono: </strong> {{ $cita->medico->telefono ?? 'No disponible' }} <br>
                                            <strong>Email: </strong> {{ $cita->medico->email ?? 'No disponible' }} <br>
                                            <strong>Descripciónde la consulta: </strong> {{ $cita->description ?? 'Sin descripción' }} <br>
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item active">
                                                  <h2 class="accordion-header" id="headingOne">
                                                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne" role="tabpanel">
                                                      Motivo
                                                    </button>
                                                  </h2>
                                              
                                                  <div id="accordionOne" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        {{ $cita->motivo ?? 'No disponible' }}
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="accordion-item">
                                                  <h2 class="accordion-header" id="headingTwo">
                                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo" role="tabpanel">
                                                      Comentario
                                                    </button>
                                                  </h2>
                                                  <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        {{ $cita->comentarios ?? 'No disponible' }}
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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


