<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especialidades = Especialidad::where('status', '!=', 3)->get();
        return view('content.especialidades.index', compact('especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.especialidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:especialidades',
            'status' => 'required|in:0,1,3',
        ]);
        Especialidad::create([
            'nombre' => $request->nombre,
            'status' => $request->status,
        ]);
        return redirect()->route('especialidades.index')->with('success', 'Especialidad creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Especialidad $especialidad)
    {
        return view('content.especialidades.show', compact('especialidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidad $especialidade)
    {
        
        return view('content.especialidades.edit', compact('especialidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Especialidad $especialidade)
    {
        
   
        $especialidade->update($request->all()); 
 
        return redirect()->route('especialidades.index')->with('success', 'Especialidad actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $especialidad = Especialidad::find($id);

        if (!$especialidad) {
            return redirect()->route('especialidades.index')->with('error', 'Especialidad no encontrada.');
        }

        // Cambia el estado en lugar de eliminar
        $especialidad->status = 3;
        $especialidad->save();

        return redirect()->route('especialidades.index')->with('success', 'Especialidad deshabilitada correctamente.');
    }

    public function activate(Especialidad $especialidad)
    {
        $especialidad->update(['status' => 1]); // Cambiar el estado a activo (1)
        return redirect()->route('especialidades.index')->with('success', 'Usuario activado correctamente.');
    }
}
