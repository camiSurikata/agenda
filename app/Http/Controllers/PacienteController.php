<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
  public function validarPaciente(Request $request)
  {
    $rut = $request->input('rut');

    // Buscar al paciente en la base de datos
    $paciente = Paciente::where('rut', $rut)->first();

    if ($paciente) {
      return response()->json([
        'registrado' => true,
        'paciente' => $paciente // Puedes devolver los datos del paciente si es necesario
      ]);
    } else {
      return response()->json([
        'registrado' => false
      ]);
    }
  }
  public function guardarPaciente(Request $request)
  {
    Paciente::create($request->all());
    return redirect('/agenda/reservar-cita')->with('success', 'Paciente registrado correctamente.');
  }
  public function mostrarFormularioRegistro(Request $request)
  {
    $rut = $request->input('rut'); // Obtiene el RUT desde la URL
    return view('content.agenda.paciente.registro_paciente', compact('rut')); // Pasa el RUT a la vista
  }




  public function index()
  {
    $pacientes = Paciente::all();
    return view('content.paciente.index', compact('pacientes'));
  }

  public function create()
  {
    return view('content.paciente.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nombre' => 'required',
      'apellido' => 'required',
      'prevision' => 'required',
      'email' => 'required',
      'telefono' => 'required',
      'sexo' => 'required|in:2,1',
      'fecha_nacimiento' => 'required|date',
      'rut' => 'required|unique:pacientes,rut',
    ]);

    Paciente::create($request->all());
    return redirect()->route('paciente.index')->with('success', 'Paciente creado correctamente.');
  }

  public function show(Paciente $paciente)
  {
    return view('content.paciente.show', compact('paciente'));
  }

  public function edit(Paciente $paciente)
  {
    return view('content.paciente.edit', compact('paciente'));
  }

  public function update(Request $request, Paciente $paciente)
  {
    $request->validate([
      'nombre' => 'required',
      'apellido' => 'required',
      'prevision' => 'required',
      'sexo' => 'required|in:1,2',
      'fecha_nacimiento' => 'required|date',
      'rut' => 'required|unique:pacientes,rut,' . $paciente->idpaciente . ',idpaciente',
    ]);

    $paciente->update($request->all());
    return redirect()->route('paciente.index')->with('success', 'Paciente actualizado correctamente.');
  }

  public function destroy(Paciente $paciente)
  {
    $paciente->delete();
    return redirect()->route('paciente.index')->with('success', 'Paciente eliminado correctamente.');
  }
}
