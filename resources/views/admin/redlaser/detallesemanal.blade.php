@extends('layouts/layoutMaster')

@section('title', 'Consolidado')

@section('vendor-style')
    {{-- tablas --}}
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
    {{-- Grafico --}}
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
@endsection

@section('vendor-script')
    {{-- TABLAS --}}
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <!-- Flat Picker -->
    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
    
    {{-- GRAFICO --}}
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script>
    var detalleSemanal = @json($detalleSemanal);
    var detalleSemanalYearPasado = @json($detalleSemanalYearPasado);
    
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="{{asset('assets/js/redLacer/grafico.js')}}"></script>
<script src="{{asset('assets/js/redLacer/tabla.js')}}"></script>
{{-- <script src="{{asset('assets/js/tables-datatables-advanced.js')}}"></script> --}}

@endsection

@section('content')
<h4 class="py-3 mb-4">
<span class="text-muted fw-light">Redlaser /</span> Consolidado
</h4>

<div class="row gy-4 mb-4">
    <!-- Cards with few info -->
    <div class="col-lg-4 col-sm-6">
    <div class="card">
        <div class="card-body">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <div class="avatar me-3">
            <div class="avatar-initial bg-label-primary rounded">
                <i class="mdi mdi-account-outline mdi-24px">
                </i>
            </div>
            </div>
            <div class="card-info">
            <div class="d-flex align-items-center">
                <h4 class="mb-0">{{number_format($promedioConversacionesLeads2, 1)}}</h4>
                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                {{-- <small class="text-danger">8.10%</small> --}}
            </div>
            <small>Promedio Conversaciones Leads 2023</small>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="col-lg-4 col-sm-6">
    <div class="card">
        <div class="card-body">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <div class="avatar me-3">
            <div class="avatar-initial bg-label-success rounded">
                <i class="mdi mdi-currency-usd mdi-24px">
                </i>
            </div>
            </div>
            <div class="card-info">
            <div class="d-flex align-items-center">
                <h4 class="mb-0">$ {{ number_format($promedioGastoDiario2, 1) }}</h4>
                {{-- <i class="mdi mdi-chevron-up text-success mdi-24px"></i> --}}
                {{-- <small class="text-success">25.8%</small> --}}
            </div>
            <small>Promedio de Gasto Diario 2023</small>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="col-lg-4 col-sm-6">
    <div class="card">
        <div class="card-body">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <div class="avatar me-3">
            <div class="avatar-initial bg-label-info rounded">
                <i class="mdi mdi-chart-bar-stacked mdi-24px">
                </i>
            </div>
            </div>
            <div class="card-info">
            <div class="d-flex align-items-center">
                <h4 class="mb-0"> {{ number_format($promedioConversacionesUniboxi2, 1) }}</h4>
                {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                {{-- <small class="text-danger">12.1%</small> --}}
            </div>
            <small>Promedio Conversaciones Uniboxi 2023</small>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="row gy-4 mb-4">
        <!-- Cards with few info -->
        <div class="col-lg-4 col-sm-6">
        <div class="card">
            <div class="card-body">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="avatar me-3">
                <div class="avatar-initial bg-label-primary rounded">
                    <i class="mdi mdi-account-outline mdi-24px">
                    </i>
                </div>
                </div>
                <div class="card-info">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0">{{number_format($promedioConversacionesLeads, 1)}}</h4>
                    {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                    {{-- <small class="text-danger">8.10%</small> --}}
                </div>
                <small>Promedio Conversaciones Leads 2024</small>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6">
        <div class="card">
            <div class="card-body">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="avatar me-3">
                <div class="avatar-initial bg-label-success rounded">
                    <i class="mdi mdi-currency-usd mdi-24px">
                    </i>
                </div>
                </div>
                <div class="card-info">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0">$ {{ number_format($promedioGastoDiario, 1) }}</h4>
                    {{-- <i class="mdi mdi-chevron-up text-success mdi-24px"></i> --}}
                    {{-- <small class="text-success">25.8%</small> --}}
                </div>
                <small>Promedio de Gasto Diario 2024</small>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6">
        <div class="card">
            <div class="card-body">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="avatar me-3">
                <div class="avatar-initial bg-label-info rounded">
                    <i class="mdi mdi-chart-bar-stacked mdi-24px">
                    </i>
                </div>
                </div>
                <div class="card-info">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0"> {{ number_format($promedioConversacionesUniboxi, 1) }}</h4>
                    {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                    {{-- <small class="text-danger">12.1%</small> --}}
                </div>
                <small>Promedio Conversaciones Uniboxi 2024</small>
                </div>
            </div>
            </div>
        </div>
        </div>
</div>


{{-- CONTENIDO --}}
    <div class="row">
        
        
        {{-- GRAFICO --}}
        <div class="col-12 mb-4">
            <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                <h5 class="card-title mb-0">Comparativa Uniboxi 2023 vs 2024</h5>
                {{-- <small class="text-muted">Commercial networks & enterprises</small> --}}
                </div>
                {{-- <div class="d-sm-flex d-none align-items-center">
                    <h5 class="mb-0 me-3">$ 100,000</h5>
                    <span class="badge bg-label-secondary rounded-pill">
                        <i class='mdi mdi-arrow-down mdi-14px text-danger'></i>
                        <span class="align-middle">20%</span>
                    </span>
                </div> --}}
            </div>
            <div class="card-body">
                <div id="lineChart"></div>
            </div>
            </div>
        </div>  
        <div class="row gy-4 mb-4">
            <!-- Cards with few info -->
            <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                    <div class="avatar-initial bg-label-primary rounded">
                        <i class="mdi mdi-chart-bar-stacked mdi-24px">
                        </i>
                    </div>
                    </div>
                    <div class="card-info">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0">{{number_format($efectividad, 1)}}%</h4>
                        {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                        {{-- <small class="text-danger">8.10%</small> --}}
                    </div>
                    <small>Efectividad ultimas 2 semanas</small>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        {{-- GRAFICO --}}
        <div class="col-12 mb-4">
            <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                <h5 class="card-title mb-0">Comparativa Meta vs Uniboxi</h5>
                {{-- <small class="text-muted">Commercial networks & enterprises</small> --}}
                </div>
                {{-- <div class="d-sm-flex d-none align-items-center">
                    <h5 class="mb-0 me-3">$ 100,000</h5>
                    <span class="badge bg-label-secondary rounded-pill">
                        <i class='mdi mdi-arrow-down mdi-14px text-danger'></i>
                        <span class="align-middle">20%</span>
                    </span>
                </div> --}}
            </div>
            <div class="card-body">
                <div id="lineChart2"></div>
            </div>
            </div>
        </div>  
        
        {{-- TABLA 2 --}}
        <div class="col-12 mb-4">
            <div class="card">
                <h5 class="card-header">Comparativo campañas Meta V/s Uniboxi</h5>
                <!--Search Form -->

                <hr class="mt-0">
                <div class="card-datatable table-responsive">
                <table class="dt-advanced-search table table-bordered">
                    <thead>
                    <tr>
                        <th></th>

                        <th>FECHA</th>
                        <th>CONVERSACIONES / LEADS</th>
                        <th>GASTO DIARIO</th>
                        <th>CONVERSACIONES UNIBOXI</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>FECHA</th>
                        <th>CONVERSACIONES / LEADS</th>
                        <th>GASTO DIARIO</th>
                        <th>CONVERSACIONES UNIBOXI</th>
                    </tr>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>
        <!--/ Advanced Search -->



        
    </div>
@endsection
