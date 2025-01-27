@extends('layouts/layoutMaster')

@section('title', 'Usuarios')
@section('content')
    <h1>Lista de Boxes</h1>
    {{-- <a href="{{ route('boxes.create') }}">Crear Nuevo Box</a> --}}
    <a class="btn btn-primary mb-3" href="{{ route('boxes.create') }}">Crear Box</a>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($boxes as $box)
                <tr>
                    <td>{{ $box->nombre }}</td>
                    <td>
                        <a href="{{ route('boxes.edit', $box) }}">Editar</a>
                        <form action="{{ route('boxes.destroy', $box) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
