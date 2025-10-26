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
        // Trae todos los usuarios (podrías agregar paginación si quieres)
        $usuarios = Usuario::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        // Muestra el formulario para crear un nuevo usuario
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombres' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6|confirmed',
            'rol_id' => 'required|integer'
        ]);

        // Crear el usuario directamente
        Usuario::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id
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
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
        ]);

        $usuario->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
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
