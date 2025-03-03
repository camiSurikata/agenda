<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
// Al importarlo tira error de undefined
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
  //use AuthenticatesUsers;
  protected function authenticated(Request $request, $user)
  {
    $user->load('permisos');
  }


  public function indexLogin()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('auth.login', ['pageConfigs' => $pageConfigs]);
  }

  public function indexRegistro()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('auth.register', ['pageConfigs' => $pageConfigs]);
  }

  public function indexPrivada()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('auth.secret', ['pageConfigs' => $pageConfigs]);
  }

  public function register(Request $request)
  {
    //validar los datos

    User::create($request->all());
    return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
  }

  public function login(Request $request)
  {

    //validacion


    $credentials = [
      "email" => $request->email,
      "password" => $request->password
    ];

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->intended(route('users.index'));
    } else {
      return redirect()->back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect(route('login'));
  }
}
