<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Subject;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener todas las tareas del usuario con relaciones
        $tasks = Task::with(['subject', 'status'])
            ->where('user_id', $user->id)
            ->get();

        // Estadísticas principales
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status.name', 'Terminada')->count();
        $pendingTasks = $tasks->where('status.name', 'Pendiente')->count();
        $notCompletedTasks = $tasks->where('status.name', '!=', 'Terminada')->count();

        // Datos para Pie Chart
        $pieData = [
            'Completadas' => $completedTasks,
            'Pendientes' => $pendingTasks,
            'No Completadas' => $notCompletedTasks - $pendingTasks
        ];

        // Datos para Bar Chart: tareas por materia
        $subjects = Subject::where('user_id', $user->id)->get();
        $barLabels = $subjects->pluck('name')->toArray();
        $barData = $subjects->map(function($subject) use ($tasks){
            return $tasks->where('subject_id', $subject->id)->count();
        })->toArray();

        // Datos para Line Chart: productividad semanal
        $weekDays = [];
        $weekData = [];
        Carbon::setLocale('es'); // Para formatear nombres de días en español

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $weekDays[] = ucfirst($date->isoFormat('dddd')); // Lunes, Martes, ...
            
            // Contar tareas completadas en ese día
            $count = $tasks->where('status.name', 'Terminada')
                        ->filter(function($task) use ($date) {
                            return $task->updated_at->format('Y-m-d') === $date->format('Y-m-d');
                        })
                        ->count();
            $weekData[] = $count;
        }

        // Actividad reciente (últimas 5 tareas)
        $recentActivities = $tasks->sortByDesc('updated_at')->take(5);

        // Pasar todo a la vista
        return view('auth.dashboard', compact(
            'tasks',
            'subjects',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'notCompletedTasks',
            'pieData',
            'barLabels',
            'barData',
            'weekDays',
            'weekData',
            'recentActivities'
        ));
    }
}