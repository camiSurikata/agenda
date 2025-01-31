<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    // Muestra todos las sucursales
    public function index()
    {
        $sucursales = Sucursal::all();  // Obtiene todas las sucursales
        return view('sucursales.index', compact('sucursales'));
    }

    // Muestra el formulario para crear una nueva sucursal
    public function create()
    {
        return view('sucursales.create');
    }

    // Guarda una nueva sucursal en la base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',  // Validación para el nombre
        ]);

        Sucursal::create($validated);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada exitosamente.');
    }

    // Muestra una sola sucursal
    public function show(Sucursal $sucursal)
    {
        return view('sucursales.show', compact('sucursal'));
    }

    // Muestra el formulario para editar una sucursal existente
    public function edit(Sucursal $sucursal)
    {
        return view('sucursales.edit', compact('sucursal'));
    }

    // Actualiza una sucursal existente
    public function update(Request $request, Sucursal $sucursal)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',  // Validación para el nombre
        ]);

        $sucursal->update($validated);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada exitosamente.');
    }

    // Elimina una sucursal
    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();

        return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada exitosamente.');
    }
}

