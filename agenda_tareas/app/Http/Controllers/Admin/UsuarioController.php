<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'contrasenia' => 'required|min:6|confirmed',
            'rol_id' => 'required|integer'
        ]);

        // Crear el usuario directamente
        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contrasenia' => Hash::make($request->contrasenia),
            'rol_id' => $request->rol_id,
            'estado' => $request->estado ?? 'activo'
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'estado' => $request->estado ?? $usuario->estado,
            'rol_id' => $request->rol_id ?? $usuario->rol_id,
        ]);

        // Si se envió una nueva contraseña
        if ($request->filled('contrasenia')) {
            $usuario->contrasenia = Hash::make($request->contrasenia);
            $usuario->save();
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
