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
<body class="theme-light"
<div class="page page-center">
    <div class="container container-tight py-4">
        <!-- Botón modo oscuro -->
        <div class="d-flex justify-content-end mb-3">
            <a href="#" class="btn btn-icon" id="theme-toggle">
                <i class="fas fa-moon d-none" id="theme-toggle-dark-icon"></i>
                <i class="fas fa-sun" id="theme-toggle-light-icon"></i>
            </a>
        </div>

        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">
                    <i class="fas fa-calendar-check me-2"></i>Agenda de Tareas
                </h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div>
                                <h4 class="alert-title">¡Oops!</h4>
                                <div class="text-muted">Las credenciales no coinciden.</div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="ejemplo@correo.com"
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                            >
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="••••••••"
                                required
                            >
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </button>
                    </div>
                </form>
            </div>

            <div class="hr-text">o</div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <a href="{{ route('register') }}" class="btn w-100">
                            Crear nueva cuenta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const html = document.documentElement;
        const toggleBtn = document.getElementById('theme-toggle');
        const toggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const toggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Función para actualizar los iconos
        function updateIcons(isDark) {
            toggleDarkIcon.classList.toggle('d-none', isDark);
            toggleLightIcon.classList.toggle('d-none', !isDark);
        }

        // Estado inicial
        let darkMode = localStorage.getItem('darkMode') === 'true' ||
                      (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
        
        // Actualizar UI inicial
        if (darkMode) {
            html.setAttribute('data-bs-theme', 'dark');
            document.body.classList.remove('theme-light');
            document.body.classList.add('theme-dark');
        }
        updateIcons(darkMode);

        // Toggle del tema
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            darkMode = !darkMode;
            
            // Guardar preferencia
            localStorage.setItem('darkMode', darkMode);
            
            // Actualizar tema
            html.setAttribute('data-bs-theme', darkMode ? 'dark' : 'light');
            document.body.classList.toggle('theme-dark', darkMode);
            document.body.classList.toggle('theme-light', !darkMode);
            
            // Actualizar iconos
            updateIcons(darkMode);
        });

        // Escuchar cambios del sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('darkMode')) {
                darkMode = e.matches;
                html.setAttribute('data-bs-theme', darkMode ? 'dark' : 'light');
                document.body.classList.toggle('theme-dark', darkMode);
                document.body.classList.toggle('theme-light', !darkMode);
                updateIcons(darkMode);
            }
        });
    });
</script>
</body>
</html>