@extends('layouts/layoutMaster')

@section('title', 'Callbell')

@section('vendor-style')
    {{-- GRAFICO NUEVO --}}
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-pyramid-funnel.min.js"></script>

    <style type="text/css">
        html,
        body,
        #container {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #container-filtro,
        #oftalmologia,
        #refractiva,
        #examenes,
        #cataratas {
            width: 100%;
            height: 400px;
            margin: 0;
            padding: 0;
        }
    </style>

    {{-- tablas --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    {{-- Grafico --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection

@section('vendor-script')
    {{-- TABLAS --}}
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Flat Picker -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

    {{-- GRAFICO --}}
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    {{-- SweetAlert2  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- FUNCIONES PARA ELIMINAR Y EDITAR --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Eliminar
            document.querySelectorAll('#eliminar').forEach(function(element) {
                element.addEventListener('click', function(event) {
                    event.preventDefault();
                    const id = this.dataset.id;

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminarlo'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Realiza la solicitud de eliminación
                            fetch('{{ route('actualizar.eliminar') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: id
                                    })
                                }).then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            '¡Eliminado!',
                                            'El registro ha sido eliminado.',
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error',
                                            'Hubo un problema al eliminar el registro.',
                                            'error'
                                        );
                                    }
                                });
                        }
                    });
                });
            });

            // EDIT
            document.querySelectorAll('.editar').forEach(function(element) {
                element.addEventListener('click', function(event) {
                    event.preventDefault();
                    const id = this.getAttribute('data-id');
                    const row = this.closest('tr');
                    const semana = row.querySelector('td:nth-child(1)').innerText;
                    const fecha = row.querySelector('td:nth-child(2)').innerText;
                    const conversacionesLeads = row.querySelector('td:nth-child(3)').innerText;
                    const gastoDiario = row.querySelector('td:nth-child(4)').innerText;
                    const conversacionesUniboxi = row.querySelector('td:nth-child(5)').innerText;

                    Swal.fire({
                        title: 'Editar Registro',
                        html: `
                            <input id="swal-input1" class="swal2-input" value="${semana}" placeholder="Semana">
                            <input id="swal-input2" class="swal2-input" value="${fecha}" placeholder="Fecha" type="date">
                            <input id="swal-input3" class="swal2-input" value="${conversacionesLeads}" placeholder="Conversaciones Leads">
                            <input id="swal-input4" class="swal2-input" value="${gastoDiario}" placeholder="Gasto Diario">
                            <input id="swal-input5" class="swal2-input" value="${conversacionesUniboxi}" placeholder="Conversaciones Uniboxi">
                        `,
                        focusConfirm: false,
                        preConfirm: () => {
                            const data = {
                                id: id,
                                semana: document.getElementById('swal-input1')
                                    .value,
                                fecha: document.getElementById('swal-input2').value,
                                conversacionesLeads: document.getElementById(
                                    'swal-input3').value,
                                gastoDiario: document.getElementById('swal-input4')
                                    .value,
                                conversacionesUniboxi: document.getElementById(
                                    'swal-input5').value,
                            };

                            return fetch('{{ route('actualizar.editar') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
                                            .getAttribute('content'),
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(data)
                                }).then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            '¡Actualizado!',
                                            'El registro ha sido actualizado.',
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error',
                                            'Hubo un problema al actualizar el registro.',
                                            'error'
                                        );
                                    }
                                });
                        }
                    });
                });
            });
        });
    </script>
@endsection

@section('page-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Actualizar Consolidado /</span> {{ $empresa }}
    </h4>

    <div class="row gy-4 mb-4">

        <form action="{{ route('consolidado.store') }}" class="row" method="POST">
            @csrf
            <div class="input-group mb-3 col-4">
                <span class="input-group-text" id="inputGroup-sizing-default">Semana</span>
                <input type="number" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="semana">
            </div>
            <div class="input-group mb-3 col-4">
                <span class="input-group-text" id="inputGroup-sizing-default">Fecha</span>
                <input type="date" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="fecha">
            </div>
            <div class="input-group mb-3 col-4">
                <span class="input-group-text" id="inputGroup-sizing-default">Conversaciones Leads</span>
                <input type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="leads">
            </div>
            <div class="input-group mb-3 col-4">
                <span class="input-group-text" id="inputGroup-sizing-default">Gasto Diario</span>
                <input type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="diario">
            </div>
            <div class="input-group mb-3 col-4">
                <span class="input-group-text" id="inputGroup-sizing-default">Conversaciones Uniboxi</span>
                <input type="text" class="form-control" aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default" name="uniboxi">
            </div>
            <div>
                <button class="btn btn-primary" type="submit">
                    Guardar
                </button>
            </div>
        </form>

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Ultimos 5 registros Consolidado /</span> {{ $empresa }}
        </h4>

        <table class="table">
            <thead>
                <tr>
                    <th>Semana</th>
                    <th>Fecha</th>
                    <th>Conversaciones Leads</th>
                    <th>Gasto Diario</th>
                    <th>Conversaciones Uniboxi</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->semana }}</td>
                        <td>{{ $item->fecha }}</td>
                        <td>{{ $item->conversacionesLeads }}</td>
                        <td>{{ $item->gastoDiario }}</td>
                        <td>{{ $item->conversacionesUniboxi }}</td>
                        <td>
                            <a href="#" data-id="{{ $item->id }}" class="editar">
                                <img src="{{ asset('img/actualizar/editar.png') }}" alt="editar" width="20px">
                            </a>

                            <a href="{{ route('actualizar.eliminar') }}" data-id="{{ $item->id }}" id="eliminar">
                                <img src="{{ asset('img/actualizar/borrar.png') }}" alt="borrar" width="20px">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('js')
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">


@endsection
