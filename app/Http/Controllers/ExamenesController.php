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
    
    public function procesamiento()
    {

        $examenes = Examen::all();
        $detalles = [
            [
                'id' => 317217,
                'paciente' => 'MARIA ZAMORA CUEVAS',
                'profesional' => 'Tecnólogo RNM Y TAC',
                'fecha' => '15 Feb 2025 a las 11:00',
                'examenes' => [
                    ['codigo' => '0404118', 'nombre' => 'Ecotomografía Vascular periférica Venosa'],
                ],
                'estado' => 'Anulado',
                'resultado' => '-',
            ],
            [
                'id' => 317194,
                'paciente' => 'FRANCISCO JAVIER RODRIGUEZ URIBE',
                'profesional' => 'IMG Rayos X (RX)',
                'fecha' => '13 Feb 2025 a las 15:20',
                'examenes' => [
                    ['codigo' => '0401060B', 'nombre' => 'Radiografía de rodilla (frontal y lateral)'],
                    ['codigo' => '0401062', 'nombre' => 'Radiografía de Proyecciones especiales'],
                    ['codigo' => '0401049', 'nombre' => 'Radiografía de columna total'],
                ],
                'estado' => 'En proceso',
                'resultado' => 'Pendiente',
            ]
        ];
        return view('content.examenes.procesamiento', compact('detalles', 'examenes'));
    }
}
