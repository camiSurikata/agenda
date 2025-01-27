<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nueva Encuesta de Satisfacción</title>
</head>

<body>
    <h1>Nueva Encuesta de Satisfacción</h1>
    <p><strong>Trato del profesional:</strong> {{ $trato_profesional }}</p>
    <p><strong>Atención administrativa:</strong> {{ $atencion_administrativa }}</p>
    <p><strong>Facilidad para agendar y pagar:</strong> {{ $facilidad_agendar }}</p>
    <p><strong>Reseña general:</strong> {{ $reseña_general }}</p>
    <p><strong>Comentarios adicionales:</strong> {{ $comentarios ?? 'Ninguno' }}</p>
    <p><strong>Envío anónimo:</strong> {{ $anonima ? 'Sí' : 'No' }}</p>
</body>

</html>
