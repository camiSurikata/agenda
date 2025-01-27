@component('layouts/sections/navbar/navbar-agenda')
@endcomponent
@component('content')
    <div class="container mt-5">
        <h2>Registro de Paciente</h2>
        <form action="/guardar-paciente" method="POST">
            @csrf
            <div class="form-group">
                <label for="rut">RUT</label>
                <input type="text" id="rut" name="rut" class="form-control" value="{{ $rut }}" readonly>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Correo Electrónico"
                    required>
            </div>
            <div class="form-group">
                <label for="prevision">Previsión</label>
                <input type="text" id="prevision" name="prevision" class="form-control" placeholder="Previsión" required>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Telefono" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
