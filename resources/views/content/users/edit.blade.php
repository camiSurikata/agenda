@extends('layouts/layoutMaster')

@section('title', 'Editar Usuario')
@section('content')
    <h1>{{ isset($user) ? 'Editar Usuario' : 'Crear Usuario' }}</h1>
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">

        <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif
            <div class="form-floating form-floating-outline mb-3">
                <input value="{{ old('name', $user->name ?? '') }}" type="text" class="form-control" id="name"
                    name="name" placeholder="Ingrese su Nombre y Apellido" autofocus>
                <label for="username">Nombre y Apellido</label>
            </div>

            <div class="form-floating form-floating-outline mb-3">
                <input value="{{ old('email', $user->email ?? '') }}" type="text" class="form-control" id="email"
                    name="email" placeholder="Ingrese su Email">
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
            <div class="form-floating form-floating-outline mb-3">
                <select name="idrol" id="form-repeater-1-3" class="form-select">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('idrol', $user->idRol ?? '') == $role->id ? 'selected' : '' }}>
                            {{ $role->nombre }}
                        </option>
                    @endforeach
                </select>

                <label for="form-repeater-1-3">Rol</label>
            </div>
            <button class="btn btn-primary d-grid w-100" type="submit">Guardar</button>
        </form>
    </div>
@endsection
