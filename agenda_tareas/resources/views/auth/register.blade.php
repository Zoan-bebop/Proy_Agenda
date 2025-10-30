@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1><i class="fas fa-user-plus"></i> Crear Cuenta</h1>
            <p>Únete a nuestra plataforma</p>
        </div>

        <div class="auth-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>¡Atención!</strong>
                    <ul class="mb-0 mt-2" style="padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nombre Completo</label>
                    <div class="input-group-custom">
                        <i class="fas fa-user"></i>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            class="form-control @error('name') is-invalid @enderror" 
                            placeholder="Juan Pérez" 
                            value="{{ old('name') }}" 
                            required
                        >
                    </div>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            class="form-control @error('email') is-invalid @enderror" 
                            placeholder="ejemplo@correo.com" 
                            value="{{ old('email') }}" 
                            required
                        >
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="form-control @error('password') is-invalid @enderror" 
                            placeholder="••••••••" 
                            required
                        >
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            class="form-control" 
                            placeholder="••••••••" 
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-check"></i> Crear Cuenta
                </button>
            </form>
        </div>

        <div class="auth-footer">
            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
        </div>
    </div>
</div>
@endsection