<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <<-- Asegurate de esto
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $view->with('subjects', Subject::where('user_id', Auth::id())
                                          ->where('status', true)
                                          ->get());
        } else {
            $view->with('subjects', collect()); // vacía si no está logueado
        }
        });
    }
}
