<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contrasenia' => Hash::make($request->password),
            'estado' => 'activo',
            'rol_id' => 2, // Por ejemplo: 2 = usuario normal
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
