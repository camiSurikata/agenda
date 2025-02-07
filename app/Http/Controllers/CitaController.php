<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Cita;
use App\Models\Especialidad;
use App\Models\HorariosMedico;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
  //
  public function mostrarFormularioReserva(Request $request)
  {
    $paciente = Paciente::where('rut', $request->rut)->first(); // Obtiene el paciente por el RUT
    $sucursales = Sucursal::all(); // Obtiene las sucursales disponibles
    $especialidades = Especialidad::all(); // Obtiene las especialidades disponibles
    $medicos = Medico::all(); // Obtiene los médicos disponibles

    return view('content.agenda.reservar-cita', compact('paciente', 'sucursales', 'especialidades', 'medicos'));
  }
  public function guardarReserva(Request $request)
  {
    // Validar los datos de la reserva
    $validated = $request->validate([
      'paciente_id' => 'required|exists:pacientes,id',
      'sucursal_id' => 'required|exists:sucursales,id',
      'especialidad_id' => 'required|exists:especialidades,id',
      'fecha' => 'required|date',
      'hora' => 'required',
    ]);

    // Crear la reserva
    Cita::create([
      'paciente_id' => $validated['paciente_id'],
      'sucursal_id' => $validated['sucursal_id'],
      'especialidad_id' => $validated['especialidad_id'],
      'fecha' => $validated['fecha'],
      'hora' => $validated['hora'],
    ]);
    return redirect()->route('reservar-cita')->with('success', 'Reserva realizada con éxito');

    // return redirect('/confirmacion-cita')->with('success', 'Cita reservada correctamente.');
  }

  public function obtenerHorariosDisponibles(Request $request)
  {
    try {
      // Validar los datos recibidos
      $validatedData = $request->validate([
        'sucursal_id' => 'required|exists:sucursales,id',
        'especialidad_id' => 'required|exists:especialidades,id',
        'medico_id' => 'required|exists:medicos,id',
      ]);

      // Simulando horarios disponibles (modifica según tu lógica de negocio)
      $horarios = HorariosMedico::with(['medico', 'sucursal'])
        ->where('id_sucursal', $validatedData['sucursal_id'])
        // ->where('especialidad_id', $validatedData['especialidad_id'])
        ->where('medico_id', $validatedData['medico_id'])
        ->where('no_atiende', 0)
        ->get();

      // Si no hay horarios disponibles
      if ($horarios->isEmpty()) {
        return response()->json(['message' => 'No hay horarios disponibles'], 200);
      }

      return response()->json(['horarios' => $horarios], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json(['error' => 'Validación fallida: ' . $e->errors()], 422);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error interno: ' . $e->getMessage()], 500);
    }
  }

  public function obtenerHorariosDisponiblesFecha(Request $request)
  {
    $request->validate([
      'sucursal_id' => 'required|integer',
      'especialidad_id' => 'required|integer',
      'medico_id' => 'required|integer',
      'start' => 'required|date',
      'end' => 'required|date',
    ]);

    $sucursalId = $request->input('sucursal_id');
    $especialidadId = $request->input('especialidad_id');
    $medicoId = $request->input('medico_id');
    $start = $request->input('start');
    $end = $request->input('end');

    $horarios = HorariosMedico::with(['medico', 'sucursal'])
        ->where('id_sucursal', $sucursalId)
        ->where('especialidad_id', $especialidadId)
        ->where('medico_id', $medicoId)
        ->whereBetween('fecha', [$start, $end])
        ->where('no_atiende', 0)
        ->get();

    return response()->json([
      'horarios' => $horarios,
    ]);
  }

  public function obtenerDiasDisponibles(Request $request)
  {
    $request->validate([
        'medico_id' => 'required|exists:medicos,id',
    ]);

    $medicoId = $request->input('medico_id');
    // Aquí puedes agregar tu lógica para obtener los días disponibles del médico
    // Por ejemplo:
    $diasDisponibles = $this->buscarDiasDisponiblesPorMedico($medicoId);

    return response()->json([
        'dias' => $diasDisponibles,
    ]);
  }

  public function index()
  {
    $citas = Cita::all();
    $medicos = Medico::all(); // Obtiene todos los médicos
    $pacientes = Paciente::all();
    $boxes = Box::all();
    return view('content.cita.index', compact('citas', 'medicos', 'pacientes', 'boxes'));
  }

  // Crear una nueva cita
  public function store(Request $request)
  {

    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'start' => 'required|date',
      'end' => 'required|date',
      'description' => 'string|max:1000',
      'paciente_id' => 'required',
      'box_id' => 'required',
      // 'sucursal_id' => 'required|exists:sucursales,id',
      // 'especialidad' => 'required|exists:especialidades,id',
      'medico_id' => 'required',
    ]);


    $cita = Cita::create($validated);

    return response()->json([
      'message' => 'Cita creada con éxito',
      'cita' => $cita // Retorna la cita con los médicos asociados
    ], 201);
  }

  // Actualizar una cita existente
  public function update(Request $request, $id)
  {
    $cita = Cita::findOrFail($id);

    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'start' => 'required|date',
      'end' => 'required|date',
    ]);

    $cita->update($validated);
    return response()->json($cita);
  }

  // Eliminar una cita
  public function destroy(Cita $cita)
  {
    $cita->delete();
    return redirect()->route('cita.index')->with('success', 'cita eliminado correctamente.');
  }
}
