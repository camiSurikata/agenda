@extends('layouts/layoutMaster')

@section('title', 'Campaña Santiago')

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
    var cataratas = @json($cataratas);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="{{asset('assets/js/redLacer/graficoMetaCataratas.js')}}"></script>
<script src="{{asset('assets/js/redLacer/tabla.js')}}"></script>
{{-- <script src="{{asset('assets/js/tables-datatables-advanced.js')}}"></script> --}}

@endsection

@section('content')
<h4 class="py-3 mb-4">
<span class="text-muted fw-light">Redlaser /</span> Meta Campaña Santiago
</h4>

    <div class="row gy-4 mb-4">
        <!-- Cards with few info -->
        <div class="col-lg-5 col-sm-6">
            <div class="card" style="background: rgba(251, 255, 6, 0.156)">
                <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-label-warning rounded">
                            <i class="mdi mdi-message-alert-outline mdi-24px"></i>
                        </div>
                        
                        
                    </div>
                    <div class="card-info">
                    <div class="d-flex align-items-center">
                        <h4 style="color:black;" class="mb-0">{{number_format($consersaciones, 0)}}</h4>
                        {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                        {{-- <small class="text-danger">8.10%</small> --}}
                    </div>
                    <small>Clics</small>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-sm-6">
        <div class="card" style="background:#d7afef77">
            <div class="card-body">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="avatar me-3">
                    <div class="avatar-initial rounded" style="background-color: rgba(128, 0, 128, 0.588);">
                        <i class="mdi mdi-currency-usd mdi-24px"></i>
                    </div>
                    
                    
                </div>
                <div class="card-info">
                <div class="d-flex align-items-center">
                    <h4 style="color: black;" class="mb-0">$ {{ number_format($porConversaciones, 0, ',', '.') }}</h4>
                    {{-- <i class="mdi mdi-chevron-up text-success mdi-24px"></i> --}}
                    {{-- <small class="text-success">25.8%</small> --}}
                </div>
                <small>Valor de clics</small>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="col-lg-5 col-sm-6">
            <div class="card" style="background: rgba(255, 6, 6, 0.156)">
                <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-label-danger rounded">
                            <i class="mdi mdi-chart-line mdi-24px"></i>
                        </div>
                        
                        
                    </div>
                    <div class="card-info">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0" style="color:black;">{{str_replace(',', '.',number_format($alcance, 0))}}</h4>
                        {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                        {{-- <small class="text-danger">8.10%</small> --}}
                    </div>
                    <small >Alcance total de la Campaña</small>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-sm-6">
            <div class="card" style="background: rgba(6, 56, 255, 0.156)">
                <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-message-alert-outline mdi-24px"></i>
                        </div>
                        
                        
                    </div>
                    <div class="card-info">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0" style="color:black;">{{ str_replace(',', '.', number_format($impresiones, 0))}}</h4>
                        {{-- <i class="mdi mdi-chevron-down text-danger mdi-24px"></i> --}}
                        {{-- <small class="text-danger">8.10%</small> --}}
                    </div>
                    <small>Impresiones total de la Campaña</small>
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
            <h5 class="card-title mb-0">Rendimiento ultima semana</h5>
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
    
    <div class="row">
    
        {{-- TABLA Consultas --}}
        <div class="col-12 mb-4">
            <div class="card">
                <h5 class="card-header">Campaña</h5>
                <div class="card-datatable text-nowrap">
                <table class="datatables-ajax table table-bordered">
                    <thead>
                    <tr>
                        <th >Fecha</th>
                        <th style="color:black;background:#efafafd5">Alcance</th>
                        <th style="color:black;background:rgba(81, 168, 255, 0.581)">Impresiones</th>
                        <th style="color:black;background:#ecefafda">Clics</th>
                        <th style="color:black;background:#d7afefda"> Valor Clic</th>
                        {{-- <th style="color:black;background:#baefafda">Importe gastado</th> --}}
                    </tr>
                    </thead>
                    <tbody>    
                        @foreach ($cataratas as $catarata)
                        <tr>
                            <td><?php echo date('d-m-y', strtotime($catarata->fecha)); ?></td>
                            <td style="color: black; background: #efafaf7a">{{ number_format($catarata->alcance, 0, ',', '.') }}</td>
                            <td style="color: black; background: rgba(81, 168, 255, 0.355)">{{ number_format($catarata->impresiones, 0, ',', '.') }}</td>
                            <td style="color:black;background:#ecefaf7f">{{$catarata->conversaciones}}</td>
                            <td style="color: black; background: #d7afef77">$ {{ number_format($catarata->porConversaciones, 0, ',', '.') }}</td>
                            {{-- <td style="color:black;background:#baefaf93">$ {{$catarata->importeGastado}}</td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                {{-- {{ $consultas->links() }} --}}
            </div>
        </div>
    </div>    



</div>
@endsection
