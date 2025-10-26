<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // ✅ Mostrar todos los roles
    public function index()
    {
        $roles = Rol::all();
        return view('admin.roles.index', compact('roles'));
    }

    // ✅ Mostrar formulario de creación
    public function create()
    {
        return view('admin.roles.create');
    }

    // ✅ Guardar nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:roles',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Rol::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    // ✅ Mostrar formulario de edición
    public function edit($id)
    {
        $rol = Rol::findOrFail($id);
        return view('admin.roles.edit', compact('rol'));
    }

    // ✅ Actualizar rol
    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100|unique:roles,nombre,' . $rol->id,
            'descripcion' => 'nullable|string|max:255',
        ]);

        $rol->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    // ✅ Eliminar rol
    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
