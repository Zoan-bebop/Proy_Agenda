@extends('layouts.adminlte')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>Agenda</b> de Tareas
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Inicia sesión para continuar</p>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Botón de Login --}}
                <div class="row">
                    <div class="col-8">
                        <a href="{{ route('register') }}" class="text-center">¿No tienes cuenta? Regístrate</a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
