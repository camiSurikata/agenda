<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use App\Helpers\MenuHelper;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Cargar el menú vertical desde el JSON
    $verticalMenuJson = File::get(base_path('resources/menu/verticalMenu.json'));
    $verticalMenuData = json_decode($verticalMenuJson, true);

    // Filtrar el menú según los permisos del usuario
    $filteredMenu = MenuHelper::getFilteredMenu($verticalMenuData['menu']);

    // Cargar el menú horizontal (sin filtrar, si no es necesario)
    $horizontalMenuJson = File::get(base_path('resources/menu/horizontalMenu.json'));
    $horizontalMenuData = json_decode($horizontalMenuJson);

    // Compartir los datos del menú con todas las vistas
    View::share('menuData', [$verticalMenuData, $horizontalMenuData]);
    View::share('filteredMenu', $filteredMenu);
  }
}
