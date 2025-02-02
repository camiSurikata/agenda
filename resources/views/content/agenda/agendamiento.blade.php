@component('layouts/sections/navbar/navbar-agenda')
    @extends('layouts/layoutMaster')

    @section('title', 'Reserva de Citas')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stepper = new Stepper(document.querySelector('.bs-stepper'));

            document.getElementById('rutForm').addEventListener('submit', function(e) {
                e.preventDefault();
                stepper.next(); // Avanza al siguiente paso
            });
        });
    </script>
@endsection

@section('content')

    <!-- Hay dos pasos restantes que hay agregar he implementar, una vez implementado se le aplicaran los estilos correspondientes -->
    <!-- Los pasos restantes son 3.Busqueda de disponibilidad y 4.Confirmacion -->

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Reserva de Citas /</span> Identificación
    </h4>

    <div class="row">
        <div class="col-12">
            <h5>Proceso de Identificación</h5>
        </div>

        <!-- Stepper -->
        <div class="col-12 mb-4">
            <div class="bs-stepper wizard-numbered mt-2">
                <div class="bs-stepper-header">
                    <!-- Paso 1: Identificación -->
                    <div class="step active" data-target="#identificacion">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="mdi mdi-account"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Identificación</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"></div>

                    <!-- Paso 2: Confirmación -->
                    <div class="step" data-target="#confirmacion">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Validación</span>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="bs-stepper-content">
                    <!-- Formulario de Identificación -->
                    <div id="identificacion" class="content active">
                        <form id="rutForm" class="mt-4">
                            <div class="form-group">
                                <input type="text" id="rut" name="rut" class="form-control text-center"
                                    placeholder="RUT Paciente (Ej: 17608512-2)" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Ingresar</button>
                        </form>
                    </div>

                    <!-- Paso de Confirmación -->
                    <div id="confirmacion" class="content">
                        <h5 class="text-center mt-4">¡RUT validado con éxito!</h5>
                        <p class="text-center">Puede continuar con la reserva de cita.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Función para validar RUT
    function validarRUT(rut) {
        rut = rut.replace(/\./g, '').replace('-', '');
        const cuerpo = rut.slice(0, -1);
        const digitoVerificador = rut.slice(-1).toUpperCase();

        if (cuerpo.length < 7) return false;

        let suma = 0;
        let multiplo = 2;

        for (let i = 1; i <= cuerpo.length; i++) {
            const index = multiplo * rut.charAt(cuerpo.length - i);
            suma += index;
            multiplo = multiplo < 7 ? multiplo + 1 : 2;
        }

        const dvEsperado = 11 - (suma % 11);
        const dv = dvEsperado === 11 ? '0' : dvEsperado === 10 ? 'K' : dvEsperado.toString();

        return dv === digitoVerificador;
    }
    $(document).ready(function() {
        $('#rutForm').on('submit', function(e) {
            e.preventDefault();

            const rut = $('#rut').val();
            const esValido = validarRUT(rut);

            const resultado = $('#resultado');
            if (esValido) {
                // Enviar el RUT al backend para verificar si está registrado
                $.ajax({
                    url: '/agenda/validar-paciente',
                    type: 'POST',
                    data: {
                        rut: rut,
                        _token: '{{ csrf_token() }}' // Agregar token CSRF para seguridad
                    },
                    success: function(response) {
                        if (response.registrado) {
                            resultado.text('✅ RUT válido. Usuario registrado.')
                                .addClass('text-success')
                                .removeClass('text-danger');

                            // Ocultar sección de identificación
                            // $('#identificacion').css('display', 'none');

                            // Mostrar sección de selección del profesional
                            // $('#seleccion').css('display', 'block');

                            // Cambiar el paso activo en el encabezado
                            // $('#iden').removeClass('active');
                            // $('#sele').addClass('active');
                            // Redirigir al formulario de registro
                            setTimeout(function() {
                                window.location.href =
                                    '/reservar-cita?rut=' +
                                    rut;
                            }, 2000);
                        } else {
                            resultado.text(
                                    '✅ RUT válido. Usuario no registrado. Redirigiendo a registro...'
                                )
                                .addClass('text-warning')
                                .removeClass('text-danger text-success');

                            // Redirigir al formulario de registro
                            setTimeout(function() {
                                window.location.href =
                                    '/registro-paciente?rut=' +
                                    rut;
                            }, 2000);
                        }
                    },
                    error: function() {
                        resultado.text('❌ Error al validar el usuario.')
                            .addClass('text-danger')
                            .removeClass('text-success');

                    }
                });
            } else {
                resultado.text('❌ RUT inválido.').addClass('text-danger').removeClass('text-success');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
  var stepper = new Stepper(document.querySelector('.bs-stepper'));
  stepper.to(2); // Mueve automáticamente al paso 2
});
</script>
