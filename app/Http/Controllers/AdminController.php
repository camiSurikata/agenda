<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Modulo;
use App\Models\Permisos;


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

    public function show($id){

        //if(auth()->user()->idRol != 1){
        //    return redirect()->route('home')->with('no-permiso', ' no admin');
        //}

        $user = User::find($id);
        $modulos = Modulo::all();
        $user_modulos = Permisos::where('idUser', '=', $id)->get();
        // dd($user);

        return view('admin.permisos.show', compact('user','modulos', 'user_modulos'));
    }

    public function store(Request $request)
    {
        //if(auth()->user()->idRol != 1){
        //    return redirect()->route('home')->with('no-permiso', ' no admin');
        //}

        $personalEspecialidad = Permisos::where('idUser', $request->usuario)->delete();

        // dd($request);
        $permisosSeleccionados = $request->input('modulo', []);

        foreach ($permisosSeleccionados as $permisoId) {
            $permiso = new Permisos();
            $permiso->idUser= $request->usuario;
            $permiso->idModulo = $permisoId;
            $permiso->save();
        }
        return redirect()->route('permisos.index')->with('permisos-exito','exito');
    }   
}
