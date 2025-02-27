<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Modulo;
use App\Models\Permisos;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function index()
    {

        //if(auth()->user()->idRol != 1){
        //    return redirect()->route('home')->with('no-permiso', ' no admin');
        //}


        $users = User::select('users.*', 'roles.nombre',)
            ->join('roles', 'users.idRol', '=', 'roles.idRoles')
            ->get();

        // $users = User::all();
        // $permisos = Permisos::where('idUser', auth()->id())->pluck('idModulo')->toArray();

        // dd($users);


        return view('admin.permisos.index', compact('users'));
    }

    public function show($id)
    {
        if (auth()->user()->idRol != 1) {
            return redirect()->route('medicos')->with('no-permiso', ' no admin');
        }

        // Obtener los nombres de los módulos desde la base de datos
        $modulosDisponibles = Modulo::select('id', 'nombre')->get();

        $modulosPermitidos = DB::table('permisos')->where('idUser', $id)->pluck('idModulo')->toArray();

        $user = User::find($id);
        $user_modulos = Permisos::where('idUser', '=', $id)->get();

        return view('admin.permisos.show', compact('modulosDisponibles', 'modulosPermitidos', 'id', 'user', 'user_modulos'));
    }

    public function store(Request $request)
    {
        //if(auth()->user()->idRol != 1){
        //    return redirect()->route('home')->with('no-permiso', ' no admin');
        //}

        Permisos::where('idUser', $request->usuario)->delete();

        // dd($request);
        $permisosSeleccionados = $request->input('modulos', []);

        foreach ($permisosSeleccionados as $modulo) {
            $permiso = new Permisos();
            $permiso->idUser = $request->usuario;
            $permiso->idModulo = $modulo;
            $permiso->save();
        }
        return redirect()->route('permisos.index')->with('permisos-exito', 'exito');
    }

    public function guardarPermisos(Request $request)
    {
        $userId = $request->input('user_id');
        $modulosSeleccionados = $request->input('modulos', []);

        // Eliminar permisos anteriores
        DB::table('permisos')->where('user_id', $userId)->delete();

        // Insertar nuevos permisos
        foreach ($modulosSeleccionados as $modulo) {
            DB::table('permisos')->insert([
                'user_id' => $userId,
                'modulo' => $modulo,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Permisos actualizados correctamente.');
    }

    public function getMenu($userId)
    {
        $permisos = DB::table('permisos')->where('user_id', $userId)->pluck('modulo')->toArray();

        $menuJson = json_decode(file_get_contents(storage_path('menu.json')), true);

        foreach ($menuJson['menu'] as &$menu) {
            if (isset($menu['submenu'])) {
                $menu['submenu'] = array_filter($menu['submenu'], function ($item) use ($permisos) {
                    return in_array($item['name'], $permisos);
                });

                if (empty($menu['submenu'])) {
                    $menu = null;
                }
            }
        }

        $menuJson['menu'] = array_filter($menuJson['menu']);

        return response()->json($menuJson);
    }
}
