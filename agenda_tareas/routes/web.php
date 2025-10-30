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
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (sin autenticación)
|--------------------------------------------------------------------------
*/

// Página principal → welcome page
Route::get('/', function () {
    return view('auth.welcome');
})->name('welcome');

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

    // 🏠 Home privado - Panel de Tareas (UNA SOLA RUTA)
    Route::get('/home', [TaskController::class, 'index'])->name('auth.home');
    
    // 🍅 Pomodoro
    Route::get('/pomodoro', function () {
        return view('auth.pomodoro');
    })->name('auth.pomodoro');
    
    // 📊 Dashboard
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('auth.dashboard');
    
    // 🟣 Panel de administración
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
    /*
    |--------------------------------------------------------------------------
    | RUTAS DE TAREAS
    | ⚠️ IMPORTANTE: Las rutas específicas deben ir ANTES de las genéricas
    |--------------------------------------------------------------------------
    */
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    
    // ⭐ RUTA CRÍTICA: Debe ir ANTES de /tasks/{task}
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    /*
    |--------------------------------------------------------------------------
    | RUTAS DE MATERIAS
    |--------------------------------------------------------------------------
    */
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    
    // Ruta específica primero
    Route::patch('/subjects/{subject}/toggle', [SubjectController::class, 'toggleStatus'])->name('subjects.toggle');
    Route::get('/subjects/active', [SubjectController::class, 'getActive'])->name('subjects.active');
    
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('auth.dashboard');

});