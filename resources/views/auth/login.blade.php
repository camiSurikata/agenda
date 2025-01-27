@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Inicio de Sesión')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('styles/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('vendor-script')
    {{-- <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script> --}}
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover" id="principal">
        <!-- /Logo -->
        <div class="row">
            <!-- /Left Section -->
            <div class="">
                {{-- <img src="{{asset('img/fondoSurikata.png')}}" alt="" height="100%" width="100%"> --}}
                <div
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(255, 255, 255, 0.7); padding: 20px; border-radius: 10px;">
                    <!-- /Left Section -->

                    <!-- Login -->
                    <div id="container-login">
                        <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('img/averclaro2.png') }}" width="300px" alt="">
                            </div>
                            <h4 class="mb-4">Inicia sesión en tu cuenta</h4>

                            <form id="formAuthentication" class="mb-3" action="{{ route('iniciar-sesion') }}"
                                method="POST">
                                @csrf
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Ingresa tu email" autofocus>
                                    <label for="email">Email</label>
                                </div>
                                <div class="mb-3">
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" id="password" class="form-control" name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" />
                                                <label for="password">Contraseña</label>
                                            </div>
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="mdi mdi-eye-off-outline"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember-me">
                                        <label class="form-check-label" for="remember-me">
                                            Recuerdame
                                        </label>
                                    </div>
                                </div>
                                <button class="btn btn-primary d-grid w-100">
                                    Ingresar
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- /Login -->
                </div>
            </div>
        @endsection
