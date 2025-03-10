<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function index()
  {
    $users = User::select('users.*', 'roles.nombre',)
      ->join('roles', 'users.idRol', '=', 'roles.idRoles')
      ->get();

    // aqui simplemente se modifica el id rol para quien tenga acceso a la vista
    if (auth()->user()->idRol != 1) {
      session()->flash('no-permiso', 'No tienes permisos de administrador.');
      return redirect()->route('home');
    }

    // dd($users);
    return view('content.users.index', compact('users'));
  }

  public function create()
  {
    $roles = Role::all();
    // dd($roles);
    return view('content.users.create', compact('roles'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users',
      'password' => 'required|string|min:8',
      'idrol' => 'required|exists:roles,id',
    ]);

    User::create($request->all());
    return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
  }

  public function show(User $user)
  {
    return view('users.show', compact('user'));
  }

  public function edit(User $user)
  {
    $roles = Role::all();

    return view('content.users.edit', compact('user', 'roles'));
  }

  public function update(Request $request, User $user)
  {
    // dd($request->all());
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'password' => 'nullable|string|min:8',
      // 'idRol' => 'required'
    ]);



    $user->update($request->except('password') + [
      'password' => $request->password ? bcrypt($request->password) : $user->password,
    ]);

    return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
  }

  public function destroy(User $user)
  {
    $user->update(['status' => 0]); // Cambiar el estado a inactivo (0)
    return redirect()->route('users.index')->with('success', 'Usuario desactivado correctamente.');
  }

  public function activate(User $user)
  {
    $user->update(['status' => 1]); // Cambiar el estado a activo (1)
    return redirect()->route('users.index')->with('success', 'Usuario activado correctamente.');
  }
}
