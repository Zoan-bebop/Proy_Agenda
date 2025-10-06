<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AgenTaN')</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-socials.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- FullCalendar CSS y JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/es.global.min.js"></script>
        
    <style>
        /* 🌑 Modo oscuro minimalista */
        body {
            background-color: #0a0a0a;
            color: #e0e0e0;
            font-family: "Inter", sans-serif;
        }

        /* 🆕 Barra de navegación vertical IZQUIERDA */
        .nav-buttons {
            width: 70px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            background: linear-gradient(180deg, #1a1a1a 0%, #0f0f0f 100%);
            border-right: 1px solid #2a2a2a;
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.3);
        }

        .nav-btn {
            background-color: transparent;
            border: none;
            color: #888;
            padding: 1rem 0;
            margin: 0 0.5rem;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.3rem;
            position: relative;
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: linear-gradient(180deg, #3b82f6, #2563eb);
            border-radius: 0 3px 3px 0;
            transition: height 0.3s ease;
        }

        .nav-btn:hover {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            transform: translateX(2px);
        }

        .nav-btn:hover::before {
            height: 60%;
        }

        .nav-btn.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1));
            color: #3b82f6;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
        }

        .nav-btn.active::before {
            height: 80%;
        }

        .nav-btn i {
            font-size: 1.5rem;
        }

        .nav-btn span {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Sidebar ajustado */
        .sidebar {
            width: 280px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 70px;
            background: linear-gradient(180deg, #1a1a1a 0%, #0f0f0f 100%);
            border-right: 1px solid #2a2a2a;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem 1rem;
            gap: 1rem;
            overflow-y: auto;
            z-index: 999;
        }

        /* Scrollbar personalizado */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #2a2a2a;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #3a3a3a;
        }

        /* Bloques dentro del sidebar */
        .sidebar-section {
            background: linear-gradient(135deg, #1e1e1e, #1a1a1a);
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .sidebar-section h6 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #888;
            margin-bottom: 0.75rem;
            font-weight: 700;
        }

        /* Elementos dentro de bloques */
        .sidebar-item {
            color: #ccc;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .sidebar-item:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.05));
            color: #3b82f6;
            transform: translateX(3px);
        }

        /* Contenido principal ajustado */
        .main-content {
            margin-left: 350px;
            padding: 2rem;
            min-height: 100vh;
        }

        /* Botones */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        /* Tarjetas de tarea */
        .task-card {
            background: linear-gradient(135deg, #1c1c1c, #181818);
            border: 1px solid #2c2c2c;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .task-card:hover {
            background: linear-gradient(135deg, #252525, #1f1f1f);
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
            cursor: pointer;
        }

        /* 📅 Mini calendario */
        .calendar-container table {
            width: 100%;
            font-size: 0.75rem;
        }
        .calendar-container th, .calendar-container td {
            padding: 0.3rem;
            text-align: center;
        }
        .calendar-container td {
            border-radius: 6px;
            transition: all 0.2s;
        }
        .calendar-container td:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1));
            cursor: pointer;
            transform: scale(1.1);
        }

        /* 🍅 Pomodoro */
        .pomodoro-timer {
            background: linear-gradient(135deg, #1e1e1e, #1a1a1a);
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        #time {
            font-family: 'Courier New', monospace;
            font-size: 1.8rem;
            font-weight: 700;
            color: #3b82f6;
        }
        .btn-sm {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }

        /* 🔚 Logout */
        .logout-btn {
            width: 100%;
            text-align: center;
        }

        /* Social icons mejorados */
        .social {
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
            opacity: 0.7;
        }

        .social:hover {
            opacity: 1;
            transform: scale(1.2);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }

        /* 🗓️ Estilos personalizados para FullCalendar (modo oscuro elegante) */
/* 🗓️ FullCalendar minimalista (oscuro compacto) */
#calendar {
    background: #141414;
    border: 1px solid #222;
    border-radius: 10px;
    padding: 0.4rem;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    color: #ccc;
    font-family: "Inter", sans-serif;
    width: 100%;
    max-width: 260px;   /* 👈 ancho controlado */
    height: 280px;      /* 👈 altura fija compacta */
    overflow: hidden;
    font-size: 0.7rem;
}


/* Barra superior (mes y flechas) */
.fc-toolbar {
    margin-bottom: 0.3rem !important;
}

.fc-toolbar-title {
    font-size: 0.9rem !important;
    font-weight: 600;
    color: #60a5fa;
}

.fc-button {
    background: none !important;
    border: none !important;
    color: #60a5fa !important;
    font-size: 0.75rem !important;
    padding: 2px 6px !important;
    border-radius: 6px;
    transition: all 0.2s;
}
.fc-button:hover {
    background: rgba(96,165,250,0.15) !important;
}

/* Cabecera de días */
.fc-col-header-cell-cushion {
    color: #888 !important;
    font-size: 0.65rem !important;
    padding: 2px 0 !important;
}

/* Días */
.fc-daygrid-day {
    border-color: #222 !important;
}
.fc-daygrid-day-number {
    font-size: 0.7rem !important;
    padding: 2px !important;
    color: #aaa !important;
}
.fc-day-today {
    background: rgba(59,130,246,0.12) !important;
}
.fc-day-today .fc-daygrid-day-number {
    color: #60a5fa !important;
}

/* Eventos */
.fc-event {
    background: #3b82f6 !important;
    border: none !important;
    color: white !important;
    border-radius: 4px;
    font-size: 0.65rem !important;
    padding: 1px 3px !important;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

/* Quitar bordes sobrantes */
.fc-theme-standard td, 
.fc-theme-standard th {
    border-color: #1e1e1e !important;
}

/* Compactar tabla */
.fc-scrollgrid {
    border: none !important;
}
.fc-daygrid {
    font-size: 0.7rem !important;
}

/* Eliminar sombra y margen extra */
.fc-view-harness {
    background: transparent !important;
}
.fc-daygrid-day.fc-day-selected {
    background: rgba(59,130,246,0.2) !important;
}

/* 🌙 Encabezado de días FullCalendar (DOM - LUN - MAR...) */
.fc-theme-standard .fc-scrollgrid {
    border: none !important;
    background: transparent !important;
}

.fc-theme-standard th {
    background: linear-gradient(135deg, #1a1a1a, #0f0f0f) !important;
    color: #3b82f6 !important;
    border: 1px solid #2a2a2a !important;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-size: 0.75rem;
    padding: 0.6rem 0 !important;
    text-align: center;
}

/* 🔳 Bordes y celdas del calendario */
.fc-theme-standard td {
    background-color: #141414 !important;
    border: 1px solid #2a2a2a !important;
    color: #e0e0e0 !important;
}

/* 📆 Día actual resaltado */
.fc-day-today {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(37, 99, 235, 0.15)) !important;
    border: 1px solid #3b82f6 !important;
}

/* 📌 Hover en días */
.fc-daygrid-day:hover {
    background: rgba(59, 130, 246, 0.1) !important;
    transform: scale(1.03);
    transition: all 0.2s ease-in-out;
}

/* 📅 Números del calendario */
.fc-daygrid-day-number {
    color: #e0e0e0 !important;
    font-weight: 600;
}

/* 🔲 Encabezado del mes (título) */
.fc-toolbar-title {
    color: #ffffff !important;
    font-weight: 700;
    text-transform: capitalize;
}
.fc .fc-daygrid-day-number {
    font-size: 0.6rem !important;
}
.fc-col-header-cell-cushion {
    font-size: 0.6rem !important;
}
.fc-toolbar-title {
    font-size: 0.75rem !important;
}


    </style>
</head>
<body>

    {{-- 🆕 Barra de navegación vertical IZQUIERDA --}}
    <div class="nav-buttons">
        <a href="{{ route('auth.home') }}" class="nav-btn {{ Request::routeIs('auth.home') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Inicio">
            <i class="bi bi-house-fill"></i>
        </a>
        <a href="{{ route('auth.dashboard') }}" class="nav-btn {{ Request::routeIs('auth.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Estadísticas">
            <i class="bi bi-bar-chart-fill"></i>
        </a>
        <a href="{{ route('auth.pomodoro') }}" class="nav-btn {{ Request::routeIs('auth.pomodoro') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Pomodoro">
            <i class="bi bi-alarm-fill"></i>
        </a>
        <a href="{{ route('subjects.index') }}" class="nav-btn {{ Request::routeIs('subjects.index') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Materias">
            <i class="bi bi-journal-bookmark-fill"></i>
        </a>
    </div>

    {{-- 🌙 Sidebar (calendario y materias) --}}
    <div class="sidebar">

        <div>
            {{-- Sección: Apps --}}
            <div class="sidebar-section text-center">
                <h6>Redes</h6>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <span class="social social-app-facebook"></span>
                    <span class="social social-app-x"></span>
                    <span class="social social-app-instagram"></span>
                </div>
            </div>

            {{-- Sección: Calendario --}}
            <div id="calendar"></div>

            {{-- Sección: Materias --}}
            <div class="sidebar-section flex-grow-1">
                <h6 class="mb-3 text-uppercase fw-bold text-secondary">Materias</h6>
                <ul class="list-unstyled mb-0">
                    @forelse($subjects as $subject)
                        <li class="sidebar-item d-flex align-items-center p-2 mb-2 rounded" 
                            style="background: rgba(255, 255, 255, 0.05); cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='rgba(255,255,255,0.15)';" 
                            onmouseout="this.style.background='rgba(255,255,255,0.05)';">

                            <i class="ti ti-book me-2 text-warning"></i>
                            <span>{{ $subject->name }}</span>
                        </li>
                    @empty
                        <li class="text-light fst-italic">No hay materias registradas</li>
                    @endforelse
                </ul>
            </div>


            {{-- Sección: Pomodoro --}}
            <div class="sidebar-section text-center text-white">
                <h6>Pomodoro</h6>
                <div id="pomodoro" class="pomodoro-timer d-flex flex-column align-items-center justify-content-center">
                    <div id="time" class="mb-3">25:00</div>
                    <div class="d-flex gap-2">
                        <button id="start" class="btn btn-primary btn-sm">▶</button>
                        <button id="pause" class="btn btn-warning btn-sm">⏸</button>
                        <button id="reset" class="btn btn-secondary btn-sm">⟳</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🔚 Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="logout-btn mt-2">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="ti ti-logout me-1"></i> Cerrar sesión
            </button>
        </form>

    </div>

    {{-- 🧱 Contenido principal --}}
    <div class="main-content">
        @yield('content')
    </div>

    {{-- 📜 Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <script>
    // 📅 FullCalendar - Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            selectable: true, // ✅ permite seleccionar fechas
            selectMirror: true,
            height: 280, // 👈 coincide con tu CSS
            contentHeight: 250,
            aspectRatio: 1.2, // 👈 ayuda a mantenerlo más cuadrado
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },

            // 👇 Esta línea permite seleccionar cualquier fecha, incluso pasada
            validRange: function() {
                return { start: null, end: null };
            },

            // 👇 Detectar clic o selección en una fecha (filtro)
            dateClick: function(info) {
                const fechaSeleccionada = info.dateStr;
                console.log('🗓️ Fecha seleccionada:', fechaSeleccionada);
                info.dayEl.classList.add('fc-day-selected');
                // Aquí puedes llamar a tu backend o filtrar las tareas
                // Ejemplo: actualizar una tabla con tareas de ese día
                filtrarTareasPorFecha(fechaSeleccionada);
            },

            // Ejemplo de eventos (puedes quitar si no usas)
            events: [
                { title: 'Tarea de ejemplo', start: '2025-10-29' }
            ]
        });

        calendar.render();
    });

    function filtrarTareasPorFecha(fecha) {
        // Aquí puedes usar fetch() o axios para traer las tareas de esa fecha
        console.log('🔍 Filtrando tareas del día:', fecha);
    }


    // 🍅 Pomodoro Timer
    document.addEventListener('DOMContentLoaded', () => {
        let timeLeft = 25 * 60;
        let timer;
        let running = false;

        const timeDisplay = document.getElementById('time');
        const startBtn = document.getElementById('start');
        const pauseBtn = document.getElementById('pause');
        const resetBtn = document.getElementById('reset');

        function updateDisplay() {
            const minutes = Math.floor(timeLeft / 60).toString().padStart(2, '0');
            const seconds = (timeLeft % 60).toString().padStart(2, '0');
            timeDisplay.textContent = `${minutes}:${seconds}`;
        }

        function startTimer() {
            if (!running) {
                running = true;
                timer = setInterval(() => {
                    if (timeLeft > 0) {
                        timeLeft--;
                        updateDisplay();
                    } else {
                        clearInterval(timer);
                        running = false;
                        Swal.fire({
                            icon: 'success',
                            title: '¡Pomodoro terminado!',
                            text: '¡Excelente trabajo! 🌟',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                }, 1000);
            }
        }

        function pauseTimer() {
            clearInterval(timer);
            running = false;
        }

        function resetTimer() {
            clearInterval(timer);
            running = false;
            timeLeft = 25 * 60;
            updateDisplay();
        }

        if (startBtn) startBtn.addEventListener('click', startTimer);
        if (pauseBtn) pauseBtn.addEventListener('click', pauseTimer);
        if (resetBtn) resetBtn.addEventListener('click', resetTimer);

        updateDisplay();
    });
    </script>

    @stack('scripts')

    <script>
        // Inicializar todos los tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner bg-dark"></div></div>'
                });
            });
        });
    </script>
</body>
</html>