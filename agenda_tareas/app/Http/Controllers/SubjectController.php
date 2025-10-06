<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects
     */
    public function index()
    {
        $subjects = Subject::where('user_id', Auth::id())
            ->withCount('tasks')
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new subject
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Show the form for editing a subject
     */
    public function edit(Subject $subject)
    {
        // Check if the subject belongs to the authenticated user
        if ($subject->user_id !== Auth::id()) {
            return redirect()->route('subjects.index')
                           ->with('error', 'No tienes permiso para editar esta materia');
        }

        return view('subjects.edit', compact('subject'));
    }

    /**
     * Store a new subject
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        Subject::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1, // Active by default
        ]);

        return redirect()->back()->with('success', 'Materia creada exitosamente');
    }

    /**
     * Update an existing subject
     */
    public function update(Request $request, Subject $subject)
    {
        // Check if the subject belongs to the authenticated user
        if ($subject->user_id !== Auth::id()) {
            return back()->with('error', 'No tienes permiso para editar esta materia');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $subject->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? $subject->status,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Materia actualizada exitosamente');
    }

    /**
     * Toggle subject status
     */
    public function toggleStatus(Subject $subject)
    {
        // Check if the subject belongs to the authenticated user
        if ($subject->user_id !== Auth::id()) {
            return back()->with('error', 'No tienes permiso para modificar esta materia');
        }

        $subject->update([
            'status' => !$subject->status,
        ]);

        return redirect()->back()->with('success', 'Estado de la materia actualizado');
    }

    /**
     * Delete a subject
     */
    public function destroy(Subject $subject)
    {
        // Check if the subject belongs to the authenticated user
        if ($subject->user_id !== Auth::id()) {
            return back()->with('error', 'No tienes permiso para eliminar esta materia');
        }

        // Check if subject has tasks
        if ($subject->tasks()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una materia que tiene tareas asignadas');
        }

        $subject->delete();

        return redirect()->back()->with('success', 'Materia eliminada exitosamente');
    }

    /**
     * Get all active subjects (for AJAX)
     */
    public function getActive()
    {
        $subjects = Subject::where('user_id', Auth::id())
            ->where('status', 1)
            ->get();

        return response()->json([
            'success' => true,
            'subjects' => $subjects
        ]);
    }
}