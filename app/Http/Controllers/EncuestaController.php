<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EncuestaController extends Controller
{
  public function enviar(Request $request)
  {
    // Validar datos
    $validated = $request->validate([
      'trato_profesional' => 'required|integer',
      'atencion_administrativa' => 'required|integer',
      'facilidad_agendar' => 'required|integer',
      'reseña_general' => 'required|integer',
      'comentarios' => 'nullable|string',
      'anonima' => 'nullable|boolean',
    ]);

    // Enviar por correo electrónico
    $email = 'camila.martinezsoto98@gmail.com'; // Cambia por el destinatario real
    Mail::send('emails.encuesta', $validated, function ($message) use ($email) {
      $message->to($email)->subject('Nueva Encuesta de Satisfacción');
    });

    return back()->with('success', '¡Gracias por completar la encuesta!');
  }
}
