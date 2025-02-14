<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloqueoProgramado;
use App\Models\Medico;

class BloqueoController extends Controller
{
  // Mostrar los bloqueos de un médico
  public function index($medicoId)
  {
    $bloqueos = BloqueoProgramado::where('medico_id', $medicoId)->get();
    dd($medicoId);
    return response()->json($bloqueos);
  }

  // Guardar un nuevo bloqueo
  public function store(Request $request, $medicoId)
  {
    $validatedData = $request->validate([
      'sucursal' => 'required|string|max:255',
      'fecha' => 'required|date',
      'hora_inicio' => 'required',
      'hora_termino' => 'required',
      'recurso' => 'required|string|max:255',
      'creado_por' => 'required|string',
    ]);

    $bloqueo = BloqueoProgramado::create(array_merge($validatedData, ['medico_id' => $medicoId]));

    return response()->json(['success' => true, 'bloqueo' => $bloqueo]);
  }

  // Eliminar un bloqueo
  public function destroy($id)
  {
    $bloqueo = BloqueoProgramado::find($id);
    if ($bloqueo) {
      $bloqueo->delete();
      return response()->json(['success' => true]);
    }
    return response()->json(['success' => false, 'message' => 'Bloqueo no encontrado'], 404);
  }
}
