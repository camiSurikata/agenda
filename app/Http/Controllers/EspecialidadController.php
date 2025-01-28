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
        $especialidades = Especialidad::all();
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
        $request->validate(['nombre' => 'required|unique:especialidads']);
        Especialidad::create($request->all());
        return redirect()->route('content.especialidades.index')->with('success', 'Especialidad creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Especialidad $especialidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidad $especialidad)
    {
        return view('content.especialidades.edit', compact('especialidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Especialidad $especialidad)
    {
        $request->validate(['nombre' => 'required|unique:especialidads,nombre,' . $especialidad->id]);
        $especialidad->update($request->all());
        return redirect()->route('content.especialidades.index')->with('success', 'Especialidad actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Especialidad $especialidad)
    {
        $especialidad->delete();
        return redirect()->route('content.especialidades.index')->with('success', 'Especialidad eliminada correctamente');
    }
}
