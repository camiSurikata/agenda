<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Cita;
use App\Models\Especialidad;
use App\Models\HorariosMedico;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Sucursal;
use App\Models\BloqueoProgramado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\CitaReservadaMail;
use Illuminate\Support\Facades\Mail;

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
    // Depuración: Verificar qué datos llegan
    // dd($request->all());

    //  Validar los datos del formulario
    $validated = $request->validate([
      'paciente_id' => 'required|integer',
      'sucursal_id' => 'required|integer',
      'especialidad_id' => 'required|integer',
      'medico_id' => 'required|integer',
      'start' => 'required|date_format:Y-m-d H:i:s',
      'end' => 'required|date_format:Y-m-d H:i:s',
      'title' => 'nullable|string|max:255',
      'description' => 'nullable|string|max:255',
      'comentarios' => 'nullable|string|max:255',
      'motivo' => 'nullable|string|max:255',
      'box_id' => 'nullable|integer'
    ]);

    try {
      // Crear y guardar la cita

      $cita = new Cita();
      $cita->title = $request->title ?? 'Cita médica';
      $cita->start = $request->start;
      $cita->end = $request->end;
      $cita->paciente_id = $request->paciente_id;
      $cita->sucursal_id = $request->sucursal_id;
      $cita->especialidad_id = $request->especialidad_id;
      $cita->medico_id = $request->medico_id;
      $cita->estado = 1; // Asignamos estado activo
      $cita->description = $request->description ?? '';
      $cita->box_id = $request->box_id ?? 1; // Opcional
      $cita->comentarios = $request->comentarios ?? null;
      $cita->motivo = $request->motivo ?? null;

      // Guardar cita
      $cita->save();
      // Enviar el correo
      $paciente = Paciente::find($request->paciente_id);

      if ($paciente) {
          // Enviar el correo al paciente
          Mail::to($paciente->email)->send(new CitaReservadaMail($cita));
      }
      // Devolver la respuesta JSON
      return response()->json($cita, 201);
      return redirect()->back()->with('success', 'Cita reservada con éxito.');
    } catch (\Exception $e) {
      Log::error('Error al guardar la cita: ' . $e->getMessage());
      return response()->json(['error' => 'Error al reservar la cita.'], 500);
    }
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
    $especialidades= Especialidad::all();
    $sucursales = Sucursal::all(); 
    return view('content.cita.index', compact('citas', 'medicos', 'pacientes', 'boxes', 'especialidades', 'sucursales'));
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
      'description' => 'nullable|string',
      'medico_id' => 'required|integer',
      'paciente_id' => 'required|integer',
      'sucursal_id' => 'required|integer',
      'especialidad_id' => 'required|integer',
      'box_id' => 'nullable|integer',
      'estado' => 'required|integer',
      'comentarios' => 'nullable|string',
      'motivo' => 'nullable|string',
    ]);

    // Actualiza la cita con los datos validados
    $cita->update($validated);

    return response()->json($cita);
  }

  // Eliminar una cita
  public function eliminarReserva(Request $request)
  {
    $citaId = $request->input('cita_id');
    $cita = Cita::find($citaId);

    if ($cita) {
      $cita->delete();
      return response()->json(['message' => 'Cita eliminada correctamente.'], 200);
    } else {
      return response()->json(['message' => 'Cita no encontrada.'], 404);
    }
  }

  public function obtenerHorarios($medico_id)
  {
    $horarios = HorariosMedico::where('medico_id', $medico_id)
      ->where('no_atiende', 0) // Filtra solo los días en que atiende
      ->get(['dia_semana', 'hora_inicio', 'hora_termino', 'descanso_inicio', 'descanso_termino']);

    $bloqueos = DB::table('bloqueos_programados')
      ->where('medico_id', $medico_id)
      ->where('fecha', '>=', now()) // Obtiene los horarios bloqueados desde la fecha de hoy en adelante
      ->get(['fecha', 'hora_inicio', 'hora_termino']); // Obtiene los horarios bloqueados

    $citas = Cita::where('medico_id', $medico_id)
      ->where('start', '>=', now()) // Obtiene las citas desde la fecha de hoy en adelante
      ->get(['start', 'end']); // Obtiene las citas


    return response()->json([
      'horarios' => $horarios,
      'bloqueos' => $bloqueos,
      'citas' => $citas
    ]);
  }

}