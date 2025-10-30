<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        // 1. Ver los datos que llegan del formulario
        // dd('LOGIN REQUEST', $request->all());

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Ver las credenciales validadas y el usuario encontrado (si existe)
        // dd([
        //     'credenciales_enviadas' => $credentials,
        //     'usuario_encontrado' => Auth::getProvider()->retrieveByCredentials($credentials)
        // ]);

        // Si quieres ver las credenciales validadas, descomenta la siguiente línea
        //dd('CREDENTIALS', $credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Depuración en caso de éxito: usuario autenticado y ruta de redirección
            return redirect()->route('home'); // o tu ruta principal
        }

        // Depuración en caso de fallo de autenticación

        // return back()->withErrors([
        //     'email' => 'Las credenciales no coinciden con nuestros registros.',
        // ]);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
