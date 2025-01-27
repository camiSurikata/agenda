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

@endsection

@section('page-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener todas las tarjetas
            const cards = document.querySelectorAll('.card');

            // Agregar evento de clic a cada tarjeta
            cards.forEach((card, index) => {
                card.addEventListener('click', function() {
                    // Determinar la URL correcta según la tarjeta
                    let url;
                    if (index === 0) {
                        url = "{{ route('actualizar.consolidado') }}";
                    } else {
                        // Ajustar esta lógica según sea necesario para otras tarjetas
                        url = "/your-url-path";
                    }

                    Swal.fire({
                        title: 'Seleccione una opción',
                        html: `
                            <div style="display: flex; justify-content: space-around;" class='text-center'>
                                <div>
                                    <a href="${url}?companyId=2">
                                        <img src="{{ asset('img/actualizar/logo-averclaro.png') }}" alt="Averclaro" width="150px">
                                    </a>
                                </div>
                                <div>
                                    <a href="${url}?companyId=1">
                                        <img src="https://www.redlaser.cl/wp-content/uploads/2023/07/home-redlaser.png" alt="Redlaser" width="150px">
                                    </a>
                                </div>
                            </div>
                        `,
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        showConfirmButton: false
                    });
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ALERTA --}}
    @if (session('metrica-error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No registrado',
            });
        </script>
    @endif
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Estadisticas /</span> Averclaro -Redlaser
    </h4>

    <div class="row gy-4 mb-4">
        {{-- CONSOLIDADO --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="">
                                <img src="{{ asset('img/actualizar/consolidar.png') }}" alt="">
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                            </div>
                            <small>CONSOLIDADO</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FACEBOOK --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card" data-card-number="2">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="">
                                <img src="{{ asset('img/actualizar/facebook.png') }}" alt="">
                                </i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                                {{-- <small class="text-danger">8.10%</small> --}}
                            </div>
                            <small>FACEBOOK</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- INSTAGRAM --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card" data-card-number="3">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="">
                                <img src="{{ asset('img/actualizar/instagram.png') }}" alt="">
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                                {{-- <small class="text-danger">8.10%</small> --}}
                            </div>
                            <small>INSTAGRAM</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- META ADS --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card" data-card-number="4">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="">
                                <img src="{{ asset('img/actualizar/meta.png') }}" alt="">
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                                {{-- <small class="text-danger">8.10%</small> --}}
                            </div>
                            <small>META ADS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GOOGLE SEARCH --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card" data-card-number="5">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="">
                                <img src="{{ asset('img/actualizar/cromo.png') }}" alt="">
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                                {{-- <small class="text-danger">8.10%</small> --}}
                            </div>
                            <small>GOOGLE SEARCH</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GOOGLE ADS --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card" data-card-number="6">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="">
                                <img src="{{ asset('img/actualizar/google.png') }}" alt="">
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                                {{-- <small class="text-danger">8.10%</small> --}}
                            </div>
                            <small>GOOGLE ADS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- REDVOISS --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card" data-card-number="7">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="avatar me-3">
                            <div class="">
                                <img src="{{ asset('img/actualizar/circulo.png') }}" alt="">
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                                {{-- <small class="text-danger">8.10%</small> --}}
                            </div>
                            <small>REDVOISS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- UNIBOXI --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card" data-card-number="8">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="">
                            <img src="https://app.uniboxi.com/static/media/logo.1f34b5b0.png" alt=""
                                width="120px">
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                                {{-- <small class="text-danger">8.10%</small> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CALLBELL --}}
        <div class="col-lg-4 col-sm-6">
            <div class="card" data-card-number="9">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="">
                            <div class="">
                                <img src="https://theme.zdassets.com/theme_assets/9354723/111035044733484269ff9761f6a54ce037df9d70.jpg"
                                    alt="" width="120px">
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0"></h4>
                                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                                {{-- <small class="text-danger">8.10%</small> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('js')
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">


@endsection
