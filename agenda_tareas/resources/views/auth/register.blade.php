@extends('layouts.adminlte')

@section('title', 'Registrarse')

@section('content')
<div class="register-box">
    <div class="register-logo">
        <b>Agenda</b> de Tareas
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Crea una nueva cuenta</p>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                {{-- Nombre --}}
                <div class="input-group mb-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" value="{{ old('nombre') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                {{-- Email --}}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                {{-- Contraseña --}}
                <div class="input-group mb-3">
                    <input type="password" name="contrasenia" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                {{-- Confirmar contraseña --}}
                <div class="input-group mb-3">
                    <input type="password" name="contrasenia_confirmation" class="form-control" placeholder="Confirmar contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                {{-- Estado (oculto o por defecto) --}}
                <input type="hidden" name="estado" value="activo">

                {{-- Botón --}}
                <div class="row">
                    <div class="col-8">
                        <a href="{{ route('login') }}" class="text-center">Ya tengo una cuenta</a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
