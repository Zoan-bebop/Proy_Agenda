<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AgenTaN')</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-socials.min.css" />

    <style>
        /* 🌑 Modo oscuro minimalista */
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: "Inter", sans-serif;
        }

        /* Sidebar general */
        .sidebar {
            width: 270px;
            position: fixed;
            top: 0;
            bottom: 0;
            background-color: #1a1a1a;
            border-right: 1px solid #2a2a2a;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
            gap: 1rem;
        }

        /* Bloques dentro del sidebar */
        .sidebar-section {
            background-color: #1e1e1e;
            border: 1px solid #2a2a2a;
            border-radius: 10px;
            padding: 0.75rem;
        }

        .sidebar-section h6 {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #aaa;
            margin-bottom: 0.5rem;
        }

        /* Elementos dentro de bloques */
        .sidebar-item {
            color: #ddd;
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .sidebar-item:hover {
            background-color: #262626;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 290px;
            padding: 2rem;
        }

        /* Botones */
        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-danger {
            background-color: #ef4444;
            border-color: #ef4444;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* Tarjetas de tarea */
        .task-card {
            background-color: #1c1c1c;
            border: 1px solid #2c2c2c;
            transition: background 0.2s;
        }

        .task-card:hover {
            background-color: #252525;
            cursor: pointer;
        }

        /* 📅 Mini calendario */
        .calendar-container table {
            width: 100%;
            font-size: 0.8rem;
        }
        .calendar-container th, .calendar-container td {
            padding: 0.25rem;
            text-align: center;
        }
        .calendar-container td:hover {
            background-color: #2a2a2a;
            border-radius: 4px;
            cursor: pointer;
        }

        /* 🍅 Pomodoro */
        .pomodoro-timer {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 0 8px rgba(255,255,255,0.05);
        }
        #time {
            font-family: monospace;
            font-size: 1.8rem;
        }
        .btn-sm {
            font-size: 0.8rem;
        }

        /* 🔚 Logout */
        .logout-btn {
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- 🌙 Sidebar --}}
    <div class="sidebar">

        <div>
            {{-- Sección: Apps --}}
            <div class="sidebar-section text-center">
                <h6>Aplicaciones</h6>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <span class="social social-app-facebook"></span>
                    <span class="social social-app-x"></span>
                    <span class="social social-app-instagram"></span>
                </div>
            </div>

            {{-- Sección: Calendario --}}
            <div class="sidebar-section">
                <h6>Calendario</h6>
                <div id="mini-calendar" class="calendar-container text-center mt-2"></div>
            </div>

            {{-- Sección: Materias --}}
            <div class="sidebar-section flex-grow-1">
                <h6>Materias</h6>
                <ul class="list-unstyled mb-0">
                    <li class="sidebar-item">Matemáticas</li>
                    <li class="sidebar-item">Programación</li>
                    <li class="sidebar-item">Historia</li>
                    <li class="sidebar-item">Diseño</li>
                </ul>
            </div>

            {{-- Sección: Pomodoro --}}
            <div class="sidebar-section text-center text-white">
                <h6>Pomodoro</h6>
                <div id="pomodoro" class="pomodoro-timer d-flex flex-column align-items-center justify-content-center">
                    <div id="time" class="display-6 fw-bold mb-3">25:00</div>
                    <div class="d-flex gap-2">
                        <button id="start" class="btn btn-primary btn-sm px-3">▶</button>
                        <button id="pause" class="btn btn-warning btn-sm px-3">⏸</button>
                        <button id="reset" class="btn btn-secondary btn-sm px-3">⟳</button>
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
    
    <script>
    // 📅 Mini calendario dinámico
    document.addEventListener('DOMContentLoaded', () => {
        const calendarContainer = document.getElementById('mini-calendar');
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth();

        const monthName = now.toLocaleString('es', { month: 'long' });
        const firstDay = new Date(year, month, 1).getDay() || 7;
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        let html = `<h6 class="text-white text-capitalize mb-1">${monthName} ${year}</h6>`;
        html += `<table class="table table-sm table-borderless text-white mb-0">
                    <thead><tr class="text-muted">
                    <th>L</th><th>M</th><th>X</th><th>J</th><th>V</th><th>S</th><th>D</th>
                    </tr></thead><tbody><tr>`;
        
        let day = 1;
        for (let i = 1; i <= 42; i++) {
            if (i < firstDay) html += "<td></td>";
            else if (day > daysInMonth) html += "<td></td>";
            else {
                const today = (day === now.getDate()) ? 'style="background-color:#3b82f6;border-radius:4px;"' : '';
                html += `<td ${today}>${day}</td>`;
                day++;
            }
            if (i % 7 === 0) html += "</tr><tr>";
        }
        html += "</tr></tbody></table>";
        calendarContainer.innerHTML = html;
    });

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
                        alert('¡Pomodoro terminado! 🌟');
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

        startBtn.addEventListener('click', startTimer);
        pauseBtn.addEventListener('click', pauseTimer);
        resetBtn.addEventListener('click', resetTimer);

        updateDisplay();
    });
    </script>

    @stack('scripts')
</body>
</html>
