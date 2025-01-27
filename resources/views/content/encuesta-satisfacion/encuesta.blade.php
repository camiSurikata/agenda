<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .question {
            margin-bottom: 20px;
        }

        .question label {
            display: block;
            margin-bottom: 10px;
        }

        .emojis {
            display: flex;
            justify-content: space-between;
        }

        .stars {
            display: flex;
            justify-content: space-between;
        }

        textarea {
            width: 100%;
            height: 80px;
            margin-top: 10px;
        }

        .submit {
            text-align: center;
            margin-top: 20px;
        }

        .submit button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">Encuesta de satisfacción</div>

        <form method="POST" action="{{ route('encuesta.enviar') }}">
            @csrf
            <!-- Pregunta 1 -->
            <div class="question">
                <label>¿Qué te pareció el trato del profesional que te atendió?</label>
                <div class="emojis">
                    <input type="radio" name="trato_profesional" value="1" required> 😡
                    <input type="radio" name="trato_profesional" value="2"> 😐
                    <input type="radio" name="trato_profesional" value="3"> 😃
                </div>
            </div>

            <!-- Pregunta 2 -->
            <div class="question">
                <label>¿Qué te pareció la atención de nuestro personal administrativo?</label>
                <div class="emojis">
                    <input type="radio" name="atencion_administrativa" value="1" required> 😡
                    <input type="radio" name="atencion_administrativa" value="2"> 😐
                    <input type="radio" name="atencion_administrativa" value="3"> 😃
                </div>
            </div>

            <!-- Pregunta 3 -->
            <div class="question">
                <label>¿Fue fácil agendar la hora y realizar el pago?</label>
                <div class="emojis">
                    <input type="radio" name="facilidad_agendar" value="1" required> 😡
                    <input type="radio" name="facilidad_agendar" value="2"> 😐
                    <input type="radio" name="facilidad_agendar" value="3"> 😃
                </div>
            </div>

            <!-- Comentarios adicionales -->
            <div class="question">
                <label>Comentarios adicionales</label>
                <textarea name="comentarios"></textarea>
            </div>

            <!-- Reseña -->
            <div class="question">
                <label>En general, ¿qué te pareció la atención?</label>
                <div class="stars">
                    <input type="radio" name="reseña_general" value="1" required> ★
                    <input type="radio" name="reseña_general" value="2"> ★★
                    <input type="radio" name="reseña_general" value="3"> ★★★
                    <input type="radio" name="reseña_general" value="4"> ★★★★
                    <input type="radio" name="reseña_general" value="5"> ★★★★★
                </div>
            </div>

            <div class="question">
                <input type="checkbox" name="anonima"> Enviar evaluación de manera anónima
            </div>

            <div class="submit">
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>
</body>

</html>
