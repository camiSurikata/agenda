@extends('layouts/layoutMaster')
<link rel="stylesheet" href="assets/vendor/libs/select2/select2.css " />
<script src="assets/vendor/libs/select2/select2.js"></script>

@section('title', 'Crear Usuario')
@section('content')
    <h1>{{ isset($user) ? 'Editar Usuario' : 'Crear Usuario' }}</h1>
    <!-- REGISTRAR -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
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
                    <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su Email">
                    <label for="email">Correo electronico</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="idRol" id="form-repeater-1-3" class="form-select">
                        @foreach ($roles as $role)
                            <option value="{{ $role->idRoles }}"
                                {{ old('idrol', $user->idrol ?? '') == $role->id ? 'selected' : '' }}>
                                {{ $role->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <label for="form-repeater-1-3">Rol</label>
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

                <button class="btn btn-primary d-grid w-100">
                    Registrar
                </button>
            </form>



        </div>
    </div>
    <!-- /Register -->
@endsection
