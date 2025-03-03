<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuHelper
{
    public static function getFilteredMenu($menu)
    {
        if (!Auth::check()) {
            return $menu; // Devuelve todo el menú si el usuario no está autenticado
        }

        $user = Auth::user();

        $userRoleId = Auth::user()->idRol; // Asegura que estás obteniendo el rol correcto
        $userPermisos = Auth::user()->permisos->pluck('idModulo')->toArray(); // Obtiene permisos del usuario

        $modulosPermitidos = DB::table('modulos')
            ->whereIn('id', $userPermisos) // Convierte los ID en Slugs
            ->pluck('nombre')
            ->toArray();

     
        $filteredMenu = [];



        foreach ($menu as $item) {
            // 🔹 Verifica si el módulo principal está permitido
            $permitido = in_array($item['name'], $modulosPermitidos);

            // 🔹 Filtra los submenús permitidos
            $filteredSubmenu = [];
            if (isset($item['submenu'])) {
                $filteredSubmenu = array_filter($item['submenu'], function ($submenu) use ($modulosPermitidos) {
                    return in_array($submenu['name'], $modulosPermitidos);
                });
            }

            // 🔹 Si el módulo principal es permitido o tiene submenús permitidos, agrégalo
            if ($permitido || !empty($filteredSubmenu)) {
                $item['submenu'] = array_values($filteredSubmenu); // Asegurar índices correctos
                $filteredMenu[] = $item;
            }
        }
        return $filteredMenu;
    }
}
