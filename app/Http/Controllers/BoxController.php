<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;

class BoxController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $boxes = Box::all();

    return view('content.boxes.index', compact('boxes'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.boxes.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'nombre' => 'required|string|max:255'
    ]);

    Box::create($request->all());

    return redirect()->route('boxes.index')->with('success', 'Box creado correctamente.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Box $box)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Box $box)
  {
    return view('content.boxes.edit', compact('box'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Box $box)
  {
    $request->validate([
      'nombre' => 'required|string|max:255'
    ]);

    $box->update($request->all());

    return redirect()->route('boxes.index')->with('success', 'Box actualizado correctamente.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Box $box)
  {
    $box->delete();
    return redirect()->route('boxes.index')->with('success', 'Box eliminado correctamente.');
  }
}
