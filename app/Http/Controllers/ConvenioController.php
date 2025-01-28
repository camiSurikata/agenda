<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use Illuminate\Http\Request;

class ConvenioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los convenios desde la base de datos
        $convenios = Convenio::where('estado', '!=', 3)->get();

        // Retornar la vista con los convenios
        return view('content.convenios.index', compact('convenios'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retornar la vista para crear un nuevo convenio
        return view('content.convenios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'convenio' => 'required|string|max:255',
            'fecha_afiliacion' => 'required|date',
            'tipo' => 'required|in:Isapre,Convenio',
            'porcentaje_descuento' => 'required|integer|min:0|max:100',
            'estado' => 'required|in:1,2,3', // Aseguramos que el estado sea uno de los tres valores válidos
        ]);

        // Crear un nuevo convenio con los datos validados
        Convenio::create($request->all());

        // Redirigir a la lista de convenios con un mensaje de éxito
        return redirect()->route('convenios.index')->with('success', 'Convenio creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Convenio $convenio)
    {
        // Retornar la vista para mostrar un convenio específico
        return view('convenios.show', compact('convenio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Convenio $convenio)
    {
        // Retornar la vista para editar un convenio existente
        return view('convenios.edit', compact('convenio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Convenio $convenio)
    {
        // Validar los datos del formulario
        $request->validate([
            'convenio' => 'required|string|max:255',
            'fecha_afiliacion' => 'required|date',
            'tipo' => 'required|in:Isapre,Convenio',
            'porcentaje_descuento' => 'required|integer|min:0|max:100',
            'estado' => 'required|in:1,2,3',
        ]);

        // Actualizar el convenio con los nuevos datos
        $convenio->update($request->all());

        // Redirigir a la lista de convenios con un mensaje de éxito
        return redirect()->route('convenios.index')->with('success', 'Convenio actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Convenio $convenio)
    {
        // Eliminar el convenio de manera lógica (modificando el estado a 3)
        $convenio->update(['estado' => 3]);

        // Redirigir a la lista de convenios con un mensaje de éxito
        return redirect()->route('convenios.index')->with('success', 'Convenio eliminado correctamente');
    }
}

