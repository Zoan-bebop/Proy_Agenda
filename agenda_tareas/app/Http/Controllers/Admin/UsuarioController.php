<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with(['persona', 'rol'])->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|unique:personas,email',
            'usuario' => 'required|string|unique:usuarios,usuario',
            'password' => 'required|min:6',
            'rol_id' => 'required|exists:roles,id'
        ]);

        // Crear la persona
        $persona = Persona::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email
        ]);

        // Crear el usuario
        Usuario::create([
            'idPersona' => $persona->id,
            'rol_id' => $request->rol_id,
            'usuario' => $request->usuario,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::with('persona')->findOrFail($id);
        $roles = Rol::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $persona = $usuario->persona;

        $persona->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email
        ]);

        $usuario->update([
            'rol_id' => $request->rol_id,
            'usuario' => $request->usuario,
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
