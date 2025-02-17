<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Cita Médica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            color: #4e48a4;
            font-size: 22px;
            font-weight: bold;
        }
        .details {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
        }
        .details p {
            margin: 8px 0;
            font-size: 16px;
        }
        .details .label {
            font-weight: bold;
            color: #555;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #4e48a4;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        #logo-clinica {
            display: block;
            margin: 0 auto 20px auto;
            text-align: center;
        }
        #logo-clinica img {
            max-height: 80px;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="logo-clinica">
            <img src="https://averclaro.cl/wp-content/uploads/2023/07/logo-nosotros.png" alt="Logo Clínica">
        </div>
        <div class="header">🏥 Confirmación de Cita Médica</div>
        <p>Estimado/a <strong>{{ $cita->paciente->nombre }}</strong>,</p>
        <p>Tu cita médica ha sido reservada con éxito. Aquí están los detalles:</p>
        
        <div class="details">
            <p><span class="label">📅 Fecha y Hora:</span> {{ \Carbon\Carbon::parse($cita->start)->format('d/m/Y h:i A') }}</p>
            <p><span class="label">👨‍⚕️ Médico:</span> {{ $cita->medico->nombre }}</p>
            <p><span class="label">🏥 Sucursal:</span> {{ $cita->sucursal->nombre }}, {{ $cita->sucursal->direccion }}</p>
            <p><span class="label">📝 Motivo:</span> {{ $cita->motivo ?? 'No especificado' }}</p>
        </div>
        <div class="footer">
            <p>Si necesitas cancelar o reprogramar tu cita, por favor contáctanos.</p>
            <p>
            <p><strong>Gracias por confiar en nosotros.</strong></p>
            <p>Nuestro teléfono es: <strong>+56 2 2582 9200</strong> O bien nos puede escribir a nuestro WhatsApp al mismo número o haciendo clic en el siguiente enlace https://wa.me/56225829200</p>
            <p><em>Equipo de </em></p>
        </div>
    </div>
</body>
</html>

