<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaController extends Controller
{
  //
  public function index()
  {
    return view('content.agenda.agendamiento');
  }
  public function validarRUT(Request $request)
  {
    $request->validate([
      'rut' => ['required', 'string', 'regex:/^\d{7,8}-[0-9Kk]{1}$/'], // Validación básica del formato
    ]);

    $rut = $request->input('rut');

    // Aquí puedes agregar tu lógica para verificar si el RUT es válido o existe en tu sistema.
    // Por ejemplo:
    // $existePaciente = $this->buscarPacientePorRUT($rut);

    // if ($existePaciente) {
    //   return response()->json([
    //     'success' => true,
    //     'redirect_url' => route('agenda/selecion-personal'), // Cambia según tu lógica
    //   ]);
    // }

    return response()->json([
      'success' => false,
      'message' => 'El RUT no corresponde a un paciente registrado.',
    ], 404);
  }
}
