@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Register Cover - Pages')

@section('vendor-style')
    <!-- Vendor -->
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
    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="auth-cover-brand d-flex align-items-center gap-2">
            <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->

            <!-- REGISTRAR -->
            <div
                class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
                <div class="w-px-400 mx-auto pt-5 pt-lg-0">


                    {{-- FORMULARIO --}}
                    <form id="formAuthentication" class="mb-3" action="{{ route('validar-registro') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Ingrese su Nombre y Apellido" autofocus>
                            <label for="username">Nombre y Apellido</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Ingrese su Email">
                            <label for="email">Correo electronico</label>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <label for="password">Contraseña</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                <label class="form-check-label" for="terms-conditions">
                                    Acepto la
                                    <a href="javascript:void(0);">política & los términos de privacidad</a>
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">
                            Registrar
                        </button>
                    </form>

                    <p class="text-center mt-2">
                        <span>¿Ya tienes una cuenta?</span>
                        <a href="{{ url('auth/login-cover') }}">
                            <span>Inicie sesión en su lugar</span>
                        </a>
                    </p>

                    <div class="divider my-4">
                        <div class="divider-text">o</div>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-facebook">
                            <i class="tf-icons mdi mdi-24px mdi-facebook"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-twitter">
                            <i class="tf-icons mdi mdi-24px mdi-twitter"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-github">
                            <i class="tf-icons mdi mdi-24px mdi-github"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-google-plus">
                            <i class="tf-icons mdi mdi-24px mdi-google"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
@endsection
