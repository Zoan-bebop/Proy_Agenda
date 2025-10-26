<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController as PublicUsuarioController;
use App\Http\Controllers\Admin\UsuarioController as AdminUsuarioController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\MateriaController;
use App\Http\Controllers\Admin\EstadoController;
use App\Http\Controllers\Admin\TareaController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (sin autenticación)
|--------------------------------------------------------------------------
*/

// Página principal → redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// 🟢 Login y logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🟢 Registro público de nuevos usuarios
Route::get('/register', [PublicUsuarioController::class, 'create'])->name('register');
Route::post('/register', [PublicUsuarioController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (requieren autenticación)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // 🏠 Home privado
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // 🔸 Rutas de Roles
    Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
    Route::get('/roles/crear', [RolController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/editar', [RolController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RolController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RolController::class, 'destroy'])->name('roles.destroy');

    // 🔸 Rutas de Usuarios
    Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [AdminUsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [AdminUsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/editar', [AdminUsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [AdminUsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [AdminUsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // 🔸 Rutas de Materias
    Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index');
    Route::get('/materias/crear', [MateriaController::class, 'create'])->name('materias.create');
    Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');
    Route::get('/materias/{id}/editar', [MateriaController::class, 'edit'])->name('materias.edit');
    Route::put('/materias/{id}', [MateriaController::class, 'update'])->name('materias.update');
    Route::delete('/materias/{id}', [MateriaController::class, 'destroy'])->name('materias.destroy');

    // 🔸 Rutas de Estados
    Route::get('/estados', [EstadoController::class, 'index'])->name('estados.index');
    Route::get('/estados/crear', [EstadoController::class, 'create'])->name('estados.create');
    Route::post('/estados', [EstadoController::class, 'store'])->name('estados.store');
    Route::get('/estados/{id}/editar', [EstadoController::class, 'edit'])->name('estados.edit');
    Route::put('/estados/{id}', [EstadoController::class, 'update'])->name('estados.update');
    Route::delete('/estados/{id}', [EstadoController::class, 'destroy'])->name('estados.destroy');

    // 🔸 Rutas de Tareas
    Route::get('/tareas', [TareaController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/crear', [TareaController::class, 'create'])->name('tareas.create');
    Route::post('/tareas', [TareaController::class, 'store'])->name('tareas.store');
    Route::get('/tareas/{id}/editar', [TareaController::class, 'edit'])->name('tareas.edit');
    Route::put('/tareas/{id}', [TareaController::class, 'update'])->name('tareas.update');
    Route::delete('/tareas/{id}', [TareaController::class, 'destroy'])->name('tareas.destroy');
});
