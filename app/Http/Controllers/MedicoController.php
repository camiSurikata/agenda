<?php

namespace App\Http\Controllers;

use App\Models\BloqueoProgramado;
use App\Models\HorariosMedico;
use App\Models\Medico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MedicoController extends Controller
{
  public function index()
  {
    $medicos = Medico::all(); // O puedes usar `where('estado', 1)` para solo activos
    // $medicos = Medico::with('horarios', 'bloqueos')->get();
    return view('content.medicos.index', compact('medicos'));
  }

  public function create()
  {
    return view('content.medicos.create');
  }

  public function store(Request $request)
  {
    // $request->validate([
    //   'nombre' => 'required|string|max:255',
    //   'telefono' => 'nullable|string|max:15',
    //   'email' => 'required|email|unique:users,email',
    //   'password' => 'required|string|min:6|confirmed',
    //   'rut' => 'required|string|unique:medicos'
    // ]);

    Medico::create([
      'nombre' => $request->nombre,
      'telefono' => $request->telefono,
      'rut' => $request->rut,
      'email' => $request->email
      // 'estado' => 1, // Activo por defecto
    ]);
    User::create([
      'name' => $request->nombre,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      // 'estado' => 1, // Activo por defecto
    ]);

    return redirect()->route('medicos.index')->with('success', 'Médico creado correctamente.');
  }

  public function editHorario($id)
  {
    $medico = Medico::with('horarios')->findOrFail($id);

    return view('content.medicos.horario', compact('medico'));
  }
  public function updateHorario(Request $request, $id)
  {
    $medico = Medico::findOrFail($id);

    // Actualiza o crea los horarios
    foreach ($request->horarios as $dia => $data) {
      HorariosMedico::updateOrCreate(
        ['medico_id' => $medico->id, 'dia_semana' => $dia],
        [
          'hora_inicio' => $data['hora_inicio'] ?? null,
          'hora_termino' => $data['hora_termino'] ?? null,
          'descanso_inicio' => $data['descanso_inicio'] ?? null,
          'descanso_termino' => $data['descanso_termino'] ?? null,
          'box_atencion' => $data['box_atencion'] ?? null,
          'no_atiende' => isset($data['no_atiende'])
        ]
      );
    }

    return redirect()->route('medicos.index')->with('success', 'Horarios actualizados correctamente.');
  }

  public function getBloqueos($id)
  {
    $bloqueos = BloqueoProgramado::where('medico_id', $id)->get();
    return response()->json($bloqueos);
  }

  public function storeBloqueo(Request $request, $id)
  {
    dd($request);
    $request->validate([
      'sucursal' => 'required|string|max:255',
      'fecha' => 'required|date',
      'hora_inicio' => 'required',
      'hora_termino' => 'required',
    ]);

    BloqueoProgramado::create([
      'medico_id' => $id,
      'sucursal' => $request->sucursal,
      'fecha' => $request->fecha,
      'hora_inicio' => $request->hora_inicio,
      'hora_termino' => $request->hora_termino,
      'creado_por' => auth()->user()->name,
      'recurso' => 1, // Fijo por ahora
    ]);

    return response()->json(['success' => true]);
  }






  public function storeHorario(Request $request, $medicoId)
  {
    $medico = Medico::findOrFail($medicoId);

    // Guarda o actualiza horarios
    foreach ($request->horarios as $horario) {
      HorariosMedico::updateOrCreate(
        ['medico_id' => $medico->id, 'dia_semana' => $horario['dia_semana']],
        $horario
      );
    }

    return redirect()->back()->with('success', 'Horarios actualizados.');
  }

  public function getMedicos($idEspecialidad)
  {
    $medicos = Medico::where('idEspecialidades', $idEspecialidad)->get();

    if ($medicos->isEmpty()) {
      return response()->json([
        'error' => 'No se encontraron médicos para esta especialidad',
        'idEspecialidad' => $idEspecialidad
      ], 404);
    }

    return response()->json($medicos);
  }


  // public function storeBloqueo(Request $request, $medicoId)
  // {
  //   $medico = Medico::findOrFail($medicoId);

  //   BloqueoProgramado::create([
  //     'medico_id' => $medico->id,
  //     'sucursal' => $request->sucursal,
  //     'fecha' => $request->fecha,
  //     'hora_inicio' => $request->hora_inicio,
  //     'hora_termino' => $request->hora_termino,
  //     'creado_por' => $request->creado_por,
  //     'recurso' => $request->recurso,
  //   ]);

  //   return redirect()->back()->with('success', 'Bloqueo programado creado.');
  // }
}
