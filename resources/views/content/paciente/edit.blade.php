@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1>Editar Paciente</h1>
        <a href="{{ route('paciente.index') }}" class="btn btn-secondary mb-3">Volver</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="pacienteForm" action="{{ route('paciente.update', $paciente->idpaciente) }}" method="POST"  class="card p-4 shadow-sm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $paciente->nombre }}"
                    required oninput="validarNombre(this)">
                <small id="nombreError" class="text-danger" style="display: none;">El nombre no puede contener números ni símbolos.</small>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $paciente->apellido }}"
                    required oninput="validarApellido(this)">
                <small id="apellidoError" class="text-danger" style="display: none;">El Apellido no puede contener números ni símbolos.</small>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $paciente->email }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $paciente->telefono }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="prevision" class="form-label">Previsión</label>
                <select id="prevision" name="prevision" class="form-select" required>
                    <option value="" disabled>Seleccione un convenio</option>
                    @foreach($convenios as $convenio)
                        <option value="{{ $convenio->id }}" 
                            {{ $paciente->prevision == $convenio->id ? 'selected' : '' }}>
                            {{ $convenio->convenio }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select id="sexo" name="sexo" class="form-select" required>
                    <option value="2" {{ $paciente->sexo == '2' ? 'selected' : '' }}>Masculino</option>
                    <option value="1" {{ $paciente->sexo == '1' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento) }}" required oninput="validarFechaNacimiento(this)">
                <small id="fechaNacimientoError" class="text-danger" style="display: none;">La fecha de nacimiento no es valida o no es realista.</small>
            </div>
            
            
            <div class="mb-3">
                <label for="rut" class="form-label">RUT</label>
                <input type="text" class="form-control" id="rut" name="rut" value="{{ $paciente->rut }}" required oninput="validarRut(this)" placeholder="Ej: XX.XXX.XXX-X">
                <small id="rutError" class="text-danger" style="display: none;">El RUT es inválido o no tiene el formato correcto.</small>
            </div>
            
            <button type="button" class="btn btn-primary mt-3" onclick="confirmarActualizacion()">Actualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function validarNombre(input) {
            let regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/; // Solo letras y espacios
            let errorMsg = document.getElementById('nombreError');

            if (!regex.test(input.value)) {
                input.classList.add('is-invalid'); // Bootstrap: borde rojo
                errorMsg.style.display = 'block'; // Mostrar mensaje de error
            } else {
                input.classList.remove('is-invalid');
                errorMsg.style.display = 'none';
            }
        }
    </script>
    <script>
        function validarApellido(input) {
            let regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/; // Solo letras y espacios
            let errorMsg = document.getElementById('apellidoError');

            if (!regex.test(input.value)) {
                input.classList.add('is-invalid'); // Bootstrap: borde rojo
                errorMsg.style.display = 'block'; // Mostrar mensaje de error
            } else {
                input.classList.remove('is-invalid');
                errorMsg.style.display = 'none';
            }
        }
    </script>

    <script>
        function validarFechaNacimiento(input) {
            let fechaNacimiento = new Date(input.value);
            let fechaHoy = new Date();
            let edadMaxima = 200;
            let errorMsg = document.getElementById('fechaNacimientoError');
            let label = input.closest('div').querySelector('label'); // Seleccionamos el label

            // Calculamos la edad
            let edad = fechaHoy.getFullYear() - fechaNacimiento.getFullYear();
            let mes = fechaHoy.getMonth() - fechaNacimiento.getMonth();
            if (mes < 0 || (mes === 0 && fechaHoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }

            
            if (fechaNacimiento > fechaHoy || edad > edadMaxima) {
                input.classList.add('is-invalid'); // Bootstrap: borde rojo
                errorMsg.style.display = 'block'; // Mostrar mensaje de error
            } else {
                errorMsg.style.display = 'none'; // Ocultar mensaje de error
            }
        }
    </script>

    <script>
        function validarRut(input) {
            let rut = input.value;
            let errorMsg = document.getElementById('rutError');
            let label = input.closest('div').querySelector('label'); // Selecciona el label
            let regex = /^\d{1,2}\.\d{3}\.\d{3}-[\dkK]$/; // Formato XX.XXX.XXX-X

            // Validación de formato
            if (!regex.test(rut)) {
                input.classList.add('is-invalid'); // Aplica borde rojo
                errorMsg.style.display = 'block'; // Muestra el mensaje de error
                label.classList.add('text-danger'); // Aplica color rojo al label
                return;
            }

            // Extraer el RUT y el dígito verificador
            let rutSinPuntos = rut.replace(/\./g, '').replace('-', '');
            let rutNumerico = rutSinPuntos.slice(0, -1);
            let dv = rutSinPuntos.slice(-1).toUpperCase();

            // Validación del dígito verificador
            if (!validarDv(rutNumerico, dv)) {
                input.classList.add('is-invalid'); // Aplica borde rojo
                errorMsg.style.display = 'block'; // Muestra el mensaje de error
                label.classList.add('text-danger'); // Aplica color rojo al label
            } else {
                input.classList.remove('is-invalid');
                errorMsg.style.display = 'none';
                label.classList.remove('text-danger'); // Elimina el color rojo del label
            }
        }

        // Función para validar el dígito verificador del RUT
        function validarDv(rut, dv) {
            let suma = 0;
            let multiplo = 2;

            // Recorre el RUT y realiza la suma
            for (let i = rut.length - 1; i >= 0; i--) {
                suma += rut.charAt(i) * multiplo;
                multiplo = (multiplo === 7) ? 2 : multiplo + 1;
            }

            // Calcula el dígito verificador
            let dvCalculado = 11 - (suma % 11);
            if (dvCalculado === 11) {
                dvCalculado = '0';
            } else if (dvCalculado === 10) {
                dvCalculado = 'K';
            }

            return dv === dvCalculado.toString();
        }

    </script>

    <script>
        function confirmarActualizacion() {
            Swal.fire({
                title: "¿Confirmar cambios?",
                text: "Estás a punto de actualizar los datos del paciente.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, actualizar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('pacienteForm').submit();
                }
            });
        }
    </script>

@endsection
