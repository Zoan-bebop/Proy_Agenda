<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\UsuarioController;

// ✅ Ruta inicial
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ✅ Grupo protegido por autenticación y rol de administrador
Route::middleware(['auth', 'admin'])->group(function () {

    /* =========================
     * CRUD DE ROLES
     * ========================= */
    Route::get('/roles', [RolController::class, 'index'])->name('roles.index');              // Listar roles
    Route::get('/roles/crear', [RolController::class, 'create'])->name('roles.create');      // Formulario crear
    Route::post('/roles', [RolController::class, 'store'])->name('roles.store');             // Guardar nuevo rol
    Route::get('/roles/editar/{id}', [RolController::class, 'edit'])->name('roles.edit');    // Editar rol
    Route::put('/roles/{id}', [RolController::class, 'update'])->name('roles.update');       // Actualizar rol
    Route::delete('/roles/{id}', [RolController::class, 'destroy'])->name('roles.destroy');  // Eliminar rol


    /* =========================
     * CRUD DE USUARIOS
     * ========================= */
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');               // Listar usuarios
    Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuarios.create');       // Formulario crear
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');              // Guardar usuario
    Route::get('/usuarios/editar/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');     // Editar usuario
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');        // Actualizar usuario
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');   // Eliminar usuario
});

// ✅ LOGIN / LOGOUT (se implementarán más adelante con AuthController)
Route::get('/login', function() { return view('auth.login'); })->name('login');
Route::post('/logout', function() {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
