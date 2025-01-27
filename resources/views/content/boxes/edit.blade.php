@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')
    <h1>Editar Box</h1>
    <form action="{{ route('boxes.update', $box) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ $box->nombre }}" required>
        <button type="submit">Actualizar</button>
    </form>
@endsection
