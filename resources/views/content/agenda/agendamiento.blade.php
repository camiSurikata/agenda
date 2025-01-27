@component('layouts/sections/navbar/navbar-agenda')
@endcomponent
@component('content')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .step-header {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }

        .step {
            text-align: center;
        }

        .step.active {
            color: #007bff;
            font-weight: bold;
        }
    </style>

    <body>
        <div class="container mt-5">
            <!-- Header -->
            <div class="step-header">
                <div class="step active" id="iden">1. Identificación</div>
                <div class="step" id="sele">2. Selección del profesional</div>
                <div class="step" id="dispo">3. Búsqueda de disponibilidad</div>
                <div class="step" id="confirm">4. Confirmación</div>
            </div>

            <!-- Formulario -->
            <div class="text-center" id="identificacion">
                {{-- <h2>Averclaro - Reserva de Citas Online</h2> --}}
                <form id="rutForm" class="mt-4">
                    <div class="form-group">
                        <input type="text" id="rut" name="rut" class="form-control text-center"
                            placeholder="RUT Paciente (Ej: 17608512-2)" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </form>
                <p id="resultado" class="mt-3 text-center"></p>
            </div>

        </div>
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
