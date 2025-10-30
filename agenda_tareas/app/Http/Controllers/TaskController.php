<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subject;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display the main task dashboard
     */
public function index(Request $request)
{
    $user = Auth::user();

    // Obtener filtro desde la request
    $filter = $request->get('filter', 'pendiente');

    // Consulta base
    $tasksQuery = Task::with(['subject', 'status'])
        ->where('user_id', $user->id);

    // Aplicar filtro
    switch ($filter) {
        case 'completado':
            $tasksQuery->where('status_id', 3); // Terminada
            break;

        case 'nocompletado':
            // Pendiente y vencida
            $tasksQuery->where('status_id', 1)
                       ->where('due_date', '<', Carbon::now());
            break;

        case 'pendiente':
        default:
            // Pendiente pero NO vencida
            $tasksQuery->where('status_id', 1)
                       ->where('due_date', '>=', Carbon::now());
            break;
    }

    // Ordenar: primero vencidas, luego por fecha
    $tasks = $tasksQuery->orderByRaw('due_date < ? DESC, due_date ASC', [Carbon::now()])
                        ->get();

    // Estadísticas
    $totalTasks = Task::where('user_id', $user->id)->count();

    $pendingTasks = Task::where('user_id', $user->id)
        ->where('status_id', 1)
        ->where('due_date', '>=', Carbon::now())
        ->count();

    $completedTasks = Task::where('user_id', $user->id)
        ->where('status_id', 3)
        ->count();

    $overdueTasks = Task::where('user_id', $user->id)
        ->where('due_date', '<', Carbon::now())
        ->where('status_id', '!=', 3)
        ->count();

    // Obtener materias activas
    $subjects = Subject::where('user_id', $user->id)
        ->where('status', true)
        ->get();

    return view('auth.home', compact(
        'tasks',
        'subjects',
        'totalTasks',
        'pendingTasks',
        'completedTasks',
        'overdueTasks',
        'filter'
    ));
}


    /**
     * Store a new task
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string', // NULLABLE PARA QUE NO SEA OBLIGATORIO
            'due_date' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Get the "Pendiente" status
        $pendingStatus = Status::where('name', 'Pendiente')->first();
        
        if (!$pendingStatus) {
            return back()->with('error', 'No se encontró el estado "Pendiente". Por favor, verifica la configuración.');
        }

        Task::create([
            'user_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'status_id' => $pendingStatus->id,
            'topic' => $request->topic,
            'description' => $request->description, // AGREGADO
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente');
    }

    /**
     * Update an existing task
     */
    public function update(Request $request, Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return back()->with('error', 'No tienes permiso para editar esta tarea');
        }

        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $task->update([
            'subject_id' => $request->subject_id,
            'topic' => $request->topic,
            'description' => $request->description, // AGREGADO
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada exitosamente');
    }

    /**
     * Update task status
     */
    public function updateStatus(Request $request, Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $task->update([
            'status_id' => $request->status_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado exitosamente'
        ]);
    }

    /**
     * Delete a task
     */
    public function destroy(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return back()->with('error', 'No tienes permiso para eliminar esta tarea');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente');
    }

    /**
     * Get task details (for AJAX requests)
     */
    public function show(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $task->load(['subject', 'status']);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }
}