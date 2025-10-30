<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Verifica que estés autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Retorna la vista home
        return view('home'); // o 'welcome' si esa es tu vista
    }
}