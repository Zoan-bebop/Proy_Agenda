@extends('layouts.tabler')

@section('title', 'Pomodoro Timer')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-12">
            <!-- Header con gradiente -->
            <div class="text-center mb-5">
                <h1 class="mb-2" style="font-size: 42px; font-weight: 800; background: linear-gradient(135deg, #3b82f6, #2563eb); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="ti ti-flame"></i> Técnica Pomodoro
                </h1>
                <p class="text-light">Aumenta tu productividad con intervalos de trabajo enfocado</p>
            </div>

            <!-- Timer Card con diseño mejorado -->
            <div class="card task-card p-5 text-center mb-4 border-0" style="background: linear-gradient(135deg, #1c1c1c, #0f0f0f); box-shadow: 0 8px 32px rgba(59, 130, 246, 0.2);">
                <div class="mb-4">
                    <span class="badge px-5 py-3" id="timer-mode" style="font-size: 18px; font-weight: 700; background: linear-gradient(135deg, #3b82f6, #2563eb); letter-spacing: 1px;">
                        <i class="ti ti-briefcase me-2"></i>TRABAJO
                    </span>
                </div>

                <!-- Timer Display con círculo de progreso -->
                <div class="position-relative d-inline-block mb-5">
                    <svg width="300" height="300" style="transform: rotate(-90deg);">
                        <circle cx="150" cy="150" r="140" fill="none" stroke="rgba(59, 130, 246, 0.1)" stroke-width="10"/>
                        <circle id="progress-ring" cx="150" cy="150" r="140" fill="none" stroke="url(#gradient)" stroke-width="10" 
                                stroke-dasharray="879.6" stroke-dashoffset="879.6" stroke-linecap="round"/>
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#2563eb;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <div id="timer-display" style="font-size: 80px; font-weight: 800; color: #fff; line-height: 1; font-family: 'Courier New', monospace; text-shadow: 0 0 30px rgba(59, 130, 246, 0.5);">
                            25:00
                        </div>
                        <div class="text-light mt-2" style="font-size: 14px; letter-spacing: 2px;">MINUTOS</div>
                    </div>
                </div>

                <!-- Control Buttons -->
                <div class="d-flex justify-content-center gap-3 mb-4">
                    <button id="btn-start" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 15px; font-weight: 700;">
                        <i class="ti ti-player-play me-2"></i>Iniciar
                    </button>
                    <button id="btn-pause" class="btn btn-warning btn-lg px-5 py-3" style="display: none; border-radius: 15px; font-weight: 700;">
                        <i class="ti ti-player-pause me-2"></i>Pausar
                    </button>
                    <button id="btn-reset" class="btn btn-secondary btn-lg px-5 py-3" style="border-radius: 15px; font-weight: 700;">
                        <i class="ti ti-refresh me-2"></i>Reiniciar
                    </button>
                </div>

                <!-- Session Counter -->
                <div class="d-flex justify-content-center gap-4 mt-4">
                    <div class="text-center">
                        <div class="d-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(5, 150, 105, 0.1)); border-radius: 12px; margin: 0 auto;">
                            <i class="ti ti-flame" style="font-size: 30px; color: #10b981;"></i>
                        </div>
                        <div style="font-size: 24px; font-weight: 700; color: #10b981;" id="session-count">0</div>
                        <div class="text-light small">Sesiones</div>
                    </div>
                    <div class="text-center">
                        <div class="d-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1)); border-radius: 12px; margin: 0 auto;">
                            <i class="ti ti-clock" style="font-size: 30px; color: #3b82f6;"></i>
                        </div>
                        <div style="font-size: 24px; font-weight: 700; color: #3b82f6;" id="time-worked">0</div>
                        <div class="text-light small">Minutos</div>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="card task-card p-4 border-0">
                <h5 class="mb-4" style="color: #fff; font-weight: 700;">
                    <i class="ti ti-settings me-2" style="color: #3b82f6;"></i>Configuración
                </h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-white">
                            <i class="ti ti-briefcase me-2" style="color: #3b82f6;"></i>Trabajo (min)
                        </label>
                        <input type="number" id="work-duration" class="form-control form-control-lg" value="25" min="1" max="60" 
                               style="background: #0f0f0f; border: 2px solid #2a2a2a; color: #fff; font-weight: 600; text-align: center;">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-white">
                            <i class="ti ti-coffee me-2" style="color: #10b981;"></i>Descanso corto (min)
                        </label>
                        <input type="number" id="short-break" class="form-control form-control-lg" value="5" min="1" max="30"
                               style="background: #0f0f0f; border: 2px solid #2a2a2a; color: #fff; font-weight: 600; text-align: center;">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-white">
                            <i class="ti ti-armchair me-2" style="color: #f59e0b;"></i>Descanso largo (min)
                        </label>
                        <input type="number" id="long-break" class="form-control form-control-lg" value="15" min="1" max="60"
                               style="background: #0f0f0f; border: 2px solid #2a2a2a; color: #fff; font-weight: 600; text-align: center;">
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card task-card p-4 border-0 mt-4">
                <h5 class="mb-3" style="color: #fff; font-weight: 700;">
                    <i class="ti ti-bulb me-2" style="color: #f59e0b;"></i>Consejos para maximizar tu productividad
                </h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 text-light">
                        <i class="ti ti-check me-2" style="color: #10b981;"></i>
                        Elimina todas las distracciones antes de iniciar
                    </li>
                    <li class="mb-2 text-light">
                        <i class="ti ti-check me-2" style="color: #10b981;"></i>
                        Toma descansos activos: estira, camina o hidrátate
                    </li>
                    <li class="mb-2 text-light">
                        <i class="ti ti-check me-2" style="color: #10b981;"></i>
                        Después de 4 pomodoros, toma un descanso largo
                    </li>
                    <li class="text-light">
                        <i class="ti ti-check me-2" style="color: #10b981;"></i>
                        Revisa tu progreso al final del día
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let timer;
    let timeLeft;
    let totalTime;
    let isRunning = false;
    let currentMode = 'work';
    let sessionsCompleted = 0;
    let totalMinutesWorked = 0;

    const display = document.getElementById('timer-display');
    const modeDisplay = document.getElementById('timer-mode');
    const sessionCount = document.getElementById('session-count');
    const timeWorked = document.getElementById('time-worked');
    const btnStart = document.getElementById('btn-start');
    const btnPause = document.getElementById('btn-pause');
    const btnReset = document.getElementById('btn-reset');
    const progressRing = document.getElementById('progress-ring');

    const workInput = document.getElementById('work-duration');
    const shortBreakInput = document.getElementById('short-break');
    const longBreakInput = document.getElementById('long-break');

    const circumference = 2 * Math.PI * 140; // 2πr

    function initTimer(mode = 'work') {
        currentMode = mode;
        
        if (mode === 'work') {
            totalTime = parseInt(workInput.value) * 60;
            modeDisplay.innerHTML = '<i class="ti ti-briefcase me-2"></i>TRABAJO';
            modeDisplay.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
        } else if (mode === 'shortBreak') {
            totalTime = parseInt(shortBreakInput.value) * 60;
            modeDisplay.innerHTML = '<i class="ti ti-coffee me-2"></i>DESCANSO CORTO';
            modeDisplay.style.background = 'linear-gradient(135deg, #10b981, #059669)';
        } else if (mode === 'longBreak') {
            totalTime = parseInt(longBreakInput.value) * 60;
            modeDisplay.innerHTML = '<i class="ti ti-armchair me-2"></i>DESCANSO LARGO';
            modeDisplay.style.background = 'linear-gradient(135deg, #f59e0b, #d97706)';
        }
        
        timeLeft = totalTime;
        updateDisplay();
        updateProgress();
    }

    function updateDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        display.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    function updateProgress() {
        const percentage = ((totalTime - timeLeft) / totalTime);
        const offset = circumference - (percentage * circumference);
        progressRing.style.strokeDashoffset = offset;
    }

    function startTimer() {
        if (isRunning) return;
        
        isRunning = true;
        btnStart.style.display = 'none';
        btnPause.style.display = 'inline-block';

        timer = setInterval(() => {
            timeLeft--;
            updateDisplay();
            updateProgress();

            if (timeLeft <= 0) {
                clearInterval(timer);
                isRunning = false;
                onTimerComplete();
            }
        }, 1000);
    }

    function pauseTimer() {
        clearInterval(timer);
        isRunning = false;
        btnStart.style.display = 'inline-block';
        btnPause.style.display = 'none';
    }

    function resetTimer() {
        clearInterval(timer);
        isRunning = false;
        btnStart.style.display = 'inline-block';
        btnPause.style.display = 'none';
        initTimer(currentMode);
    }

    function onTimerComplete() {
        Swal.fire({
            icon: 'success',
            title: currentMode === 'work' ? '¡Tiempo de descanso! ☕' : '¡Hora de trabajar! 💪',
            text: currentMode === 'work' ? 'Has completado una sesión de trabajo' : 'Has completado tu descanso',
            confirmButtonColor: '#3b82f6',
            background: '#1c1c1c',
            color: '#fff'
        });

        if (currentMode === 'work') {
            sessionsCompleted++;
            totalMinutesWorked += parseInt(workInput.value);
            sessionCount.textContent = sessionsCompleted;
            timeWorked.textContent = totalMinutesWorked;
            
            if (sessionsCompleted % 4 === 0) {
                initTimer('longBreak');
            } else {
                initTimer('shortBreak');
            }
        } else {
            initTimer('work');
        }

        btnStart.style.display = 'inline-block';
        btnPause.style.display = 'none';
    }

    // Event listeners
    btnStart.addEventListener('click', startTimer);
    btnPause.addEventListener('click', pauseTimer);
    btnReset.addEventListener('click', resetTimer);

    // Initialize
    initTimer('work');
    progressRing.style.strokeDasharray = circumference;
    progressRing.style.strokeDashoffset = circumference;
</script>
@endpush