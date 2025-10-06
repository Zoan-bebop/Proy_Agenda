<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Iniciar Sesión | Agenda de Tareas</title>

    <!-- CSS files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler-flags.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler-payments.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler-vendors.min.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tema oscuro -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler-dark.min.css">
    
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>

    <!-- Script para detectar tema del sistema y mantener preferencia -->
    <script>
        // Verifica localStorage o preferencia del sistema
        let darkMode = localStorage.getItem('darkMode') === 'true' || 
                      (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
        
        // Aplica el tema inicial
        if (darkMode) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        }
    </script>
</head>
<body>
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="mb-4 text-center">
                                <h1 class="h3 mb-1"><i class="fas fa-user-plus me-2"></i>Crear Cuenta</h1>
                                <p class="text-muted mb-0">Únete a nuestra plataforma</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger d-flex align-items-start">
                                    <span class="me-2"><i class="fas fa-exclamation-circle"></i></span>
                                    <div>
                                        <strong>¡Atención!</strong>
                                        <ul class="mb-0 mt-2" style="padding-left: 20px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('register.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre Completo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
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
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
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
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
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
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
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

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-user-check me-2"></i> Crear Cuenta
                                    </button>
                                </div>
                            </form>

                            <div class="text-center text-muted">
                                <small>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>