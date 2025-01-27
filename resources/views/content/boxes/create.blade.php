@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')
    <h1>Crear Nuevo Box</h1>
    <form action="{{ route('boxes.store') }}" method="POST">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <button type="submit">Guardar</button>
    </form>
@endsection
