<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\MenuHelper;
use Illuminate\Support\Facades\File;

class ContentNavbarController extends Controller
{
    public function someMethod()
    {
        // Leer el archivo JSON
        $path = resource_path('menu\verticalMenu.json');

        if (!File::exists($path)) {
            dd("El archivo JSON no existe en: " . $path);
        }

        $json = File::get($path);
        $menu = json_decode($json, true)['menu'] ?? [];

        if ($menu === null) {
            dd("Error al decodificar JSON: " . json_last_error_msg());
        }

        // Aplicar filtro de menú
        $filteredMenu = MenuHelper::getFilteredMenu($menu);

        // 🚨 Agrega este dd para ver qué se está filtrando
        //die(var_dump($filteredMenu));

        return view('layouts.contentNavbarLayout', compact('filteredMenu'));
    }
}
