<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MenuHelper
{
    public static function getFilteredMenu($menu)
    {
        if (!Auth::check()) {
            return $menu;
        }

        $user = Auth::user();
        if (!$user) {
            return [];
        }
        $permisos = DB::table('permisos')->where('idUser', $user->id)->first();
        $userPermisos = $permisos ? DB::table('permisos')->where('idUser', $user->id)->pluck('idModulo')->toArray() : [];
        $filteredMenu = [];

        foreach ($menu as $item) {
            // 🔹 Filtrar los submenús permitidos
            $filteredSubmenu = [];
            if (isset($item['submenu']) && is_array($item['submenu'])) {
                $filteredSubmenu = array_filter($item['submenu'], function ($submenu) use ($userPermisos) {
                    return isset($submenu['idModulo']) && in_array($submenu['idModulo'], $userPermisos);
                });
            }

            // 🔹 Mostrar el menú solo si tiene submenús permitidos
            if (!empty($filteredSubmenu)) {
                $item['submenu'] = array_values($filteredSubmenu); // Reindexar array
                $filteredMenu[] = $item;
            }
        }

        return $filteredMenu;
    }
}
