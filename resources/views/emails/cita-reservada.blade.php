<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Cita</title>
</head>
<body>
    <h1>Su cita ha sido reservada</h1>
    <p>Detalles de la cita:</p>
    <ul>
        <li><strong>Fecha:</strong> {{ $cita->start }}</li>
        <li><strong>Hora:</strong> {{ $cita->title }}</li>
        <li><strong>Paciente:</strong> {{ $cita->paciente_id }}</li>
    </ul>
</body>
</html>
