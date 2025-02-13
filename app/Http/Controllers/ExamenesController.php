<?php

namespace App\Http\Controllers;

use App\Models\Examen;

class ExamenesController extends Controller
{
    public function index()
    {
        
        $examenes = Examen::all();
        return view('content.examenes.index', ['examenes' => $examenes]);
    }
}
