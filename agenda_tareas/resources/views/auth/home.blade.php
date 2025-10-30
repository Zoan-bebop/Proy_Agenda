@extends('layouts.tabler')

@section('title', 'Panel de Tareas')

@section('content')
<div class="container-fluid" style="padding-bottom: 150px;">
    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-x me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header con gradiente -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="mb-2" style="font-size: 42px; font-weight: 800; background: linear-gradient(135deg, #3b82f6, #2563eb); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Panel Principal
            </h1>
            <p class="text-light mb-0">Gestiona tus tareas de manera eficiente</p>
        </div>

        <div class="d-flex align-items-center gap-3">
            @if(Auth::check() && Auth::user()->rol == 1)
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light px-4">
                    <i class="ti ti-user-cog me-2"></i> Admin
                </a>
            @endif
        </div>
    </div>

    {{-- Resumen de estadísticas rápidas --}}
    <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card task-card p-4 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="ti ti-clipboard-list" style="font-size: 24px; color: #3b82f6;"></i>
                    </div>
                    <div>
                        <p class="text-light mb-0 small">Total</p>
                        <h3 class="mb-0 text-white">{{ $totalTasks }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card task-card p-4 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(217, 119, 6, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="ti ti-clock" style="font-size: 24px; color: #f59e0b;"></i>
                    </div>
                    <div>
                        <p class="text-light mb-0 small">Pendientes</p>
                        <h3 class="mb-0 text-warning">{{ $pendingTasks }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card task-card p-4 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(5, 150, 105, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="ti ti-circle-check" style="font-size: 24px; color: #10b981;"></i>
                    </div>
                    <div>
                        <p class="text-light mb-0 small">Completadas</p>
                        <h3 class="mb-0 text-success">{{ $completedTasks }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card task-card p-4 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 38, 38, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="ti ti-x" style="font-size: 24px; color: #ef4444;"></i>
                    </div>
                    <div>
                        <p class="text-light mb-0 small">Vencidas</p>
                        <h3 class="mb-0 text-danger">{{ $overdueTasks }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🧭 Barra de filtros minimalista --}}
    <div class="card task-card p-3 mb-4 border-0">
        <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
            <a href="{{ route('tasks.index', ['filter' => 'pendiente']) }}" 
               class="btn-filter {{ $filter == 'pendiente' ? 'active' : '' }}">
                <i class="ti ti-clock"></i>
                <span>Pendiente</span>
            </a>
            <a href="{{ route('tasks.index', ['filter' => 'completado']) }}" 
               class="btn-filter {{ $filter == 'completado' ? 'active' : '' }}">
                <i class="ti ti-circle-check"></i>
                <span>Completado</span>
            </a>
            <a href="{{ route('tasks.index', ['filter' => 'nocompletado']) }}" 
               class="btn-filter {{ $filter == 'nocompletado' ? 'active' : '' }}">
                <i class="ti ti-x"></i>
                <span>No completado</span>
            </a>
        </div>
    </div>

    {{-- 🧾 Lista de tareas --}}
    <div class="mb-4">
        <h3 class="text-white mb-4">
            <i class="ti ti-list me-2"></i>Mis Tareas
        </h3>
    </div>

    <div class="row" id="task-list">
        @forelse($tasks as $task)
            <div class="col-12 mb-3">
                <div class="card task-card p-4 border-0" style="cursor: pointer;" onclick="editTask({{ $task->id }})">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1)); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="ti ti-clipboard-text" style="font-size: 20px; color: #3b82f6;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="mb-1 text-white">{{ $task->topic }}</h4>
                                <p class="text-light mb-0 small">{{ Str::limit($task->description ?? 'Sin descripción', 80) }}</p>
                                <div class="mt-2">
                                    <span class="badge bg-secondary me-2">
                                        <i class="ti ti-calendar me-1"></i>
                                        @php
                                            $date = \Carbon\Carbon::parse($task->due_date);
                                            echo $date->format('d/m/Y');
                                        @endphp
                                    </span>
                                    <span class="badge bg-info">
                                        <i class="ti ti-book me-1"></i>{{ $task->subject->name }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Toggle + Badge + Delete Button -->
                        <div class="d-flex flex-column align-items-end gap-2" onclick="event.stopPropagation();">
                            <div class="form-check form-switch">
                                <input class="form-check-input task-status-toggle" 
                                       type="checkbox" 
                                       id="taskStatus{{ $task->id }}" 
                                       data-task-id="{{ $task->id }}"
                                       data-current-status="{{ $task->status_id }}"
                                       {{ $task->status_id == 3 ? 'checked' : '' }}>
                                <label class="form-check-label text-white small" for="taskStatus{{ $task->id }}">
                                    Terminado
                                </label>
                            </div>

                            <span id="taskBadge{{ $task->id }}" class="badge px-3 py-2
                                @if($task->status_id == 1) bg-warning
                                @elseif($task->status_id == 3) bg-success
                                @elseif($task->status_id == 2) bg-info
                                @elseif($task->status_id == 4) bg-danger
                                @elseif($task->status_id == 5) bg-secondary
                                @else bg-dark
                                @endif">
                                {{ $task->status->name }}
                            </span>

                            <button type="button" class="btn-delete-minimal" data-task-id="{{ $task->id }}">
                                <i class="ti ti-trash"></i>
                                <span>Eliminar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card task-card p-5 border-0 text-center">
                    <i class="ti ti-clipboard-off" style="font-size: 64px; color: #3b82f6; opacity: 0.3;"></i>
                    <h4 class="text-white mt-3">No hay tareas {{ $filter }}s</h4>
                    <p class="text-light">¡Comienza agregando tu primera tarea!</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- ➕ Botón "Agregar Tarea" fijo --}}
    <div class="fixed-bottom-btn">
        <button type="button" class="btn btn-primary btn-lg px-5 py-3 shadow-lg"
            data-bs-toggle="modal" data-bs-target="#taskModal" onclick="newTask()"
            style="border-radius: 50px; font-weight: 700; font-size: 1.2rem; background: linear-gradient(135deg, #3b82f6, #2563eb); border: none;">
            <i class="ti ti-plus me-2"></i> Agregar Tarea
        </button>
    </div>

    {{-- 🪟 Modal de tarea --}}
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, #1c1c1c, #181818); border:1px solid #3b82f6;">
                <form id="taskForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    
                    <div class="modal-header border-bottom border-secondary">
                        <h5 class="modal-title text-white d-flex align-items-center" id="taskModalLabel">
                            <i class="ti ti-edit me-2"></i><span id="modalTitle">Agregar tarea</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="task-title" class="form-label text-white fw-bold">
                                <i class="ti ti-heading me-2"></i>Título
                            </label>
                            <input type="text" class="form-control form-control-lg" id="task-title" name="topic" required placeholder="Ej. Ensayo de Literatura" style="background: #0f0f0f; border: 1px solid #2a2a2a; color: #fff;">
                        </div>
                        
                        <div class="mb-4">
                            <label for="task-desc" class="form-label text-white fw-bold">
                                <i class="ti ti-align-left me-2"></i>Descripción (opcional)
                            </label>
                            <textarea class="form-control" id="task-desc" name="description" rows="4" placeholder="Detalles de la tarea..." style="background: #0f0f0f; border: 1px solid #2a2a2a; color: #fff;"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="task-date" class="form-label text-white fw-bold">
                                    <i class="ti ti-calendar me-2"></i>Fecha límite
                                </label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="task-date-hidden" name="due_date" required style="display: none;">
                                    <input type="text" class="form-control" id="task-date" required 
                                          placeholder="DD/MM/AAAA"
                                          style="background: #0f0f0f; border: 1px solid #2a2a2a; color: #fff;">
                                    <span class="input-group-text" style="background: #1a1a1a; border: 1px solid #2a2a2a; color: #3b82f6; cursor: pointer;" id="calendar-trigger">
                                        <i class="ti ti-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="task-subject" class="form-label text-white fw-bold">
                                    <i class="ti ti-book me-2"></i>Materia
                                </label>
                                <select id="task-subject" name="subject_id" class="form-select" required style="background: #0f0f0f; border: 1px solid #2a2a2a; color: #fff;">
                                    <option value="">Seleccionar materia</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="ti ti-x me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti ti-check me-2"></i>Guardar tarea
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<style>
/* 🎯 Botón fijo en la parte inferior */
.fixed-bottom-btn {
    position: fixed;
    bottom: 30px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    z-index: 1000;
    pointer-events: none;
}

.fixed-bottom-btn button {
    pointer-events: all;
}

/* 🌈 Botón "Agregar tarea" */
.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: scale(1.05);
    box-shadow: 0 0 25px rgba(59, 130, 246, 0.6);
}

/* 🎨 Botones de filtro minimalistas */
.btn-filter {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #9ca3af;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-filter i {
    font-size: 16px;
}

.btn-filter:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(59, 130, 246, 0.3);
    color: #3b82f6;
    transform: translateY(-1px);
}

.btn-filter.active {
    background: rgba(59, 130, 246, 0.15);
    border-color: #3b82f6;
    color: #3b82f6;
    font-weight: 600;
}

/* 🗑️ Botón eliminar minimalista */
.btn-delete-minimal {
    background: transparent;
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #ef4444;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-delete-minimal i {
    font-size: 16px;
}

.btn-delete-minimal:hover {
    background: rgba(239, 68, 68, 0.1);
    border-color: #ef4444;
    transform: translateY(-1px);
}

/* 🌙 Flatpickr - calendario oscuro */
.flatpickr-calendar {
    background: #1a1a1a !important;
    border: 2px solid #3b82f6 !important;
    border-radius: 16px !important;
    box-shadow: 0 10px 40px rgba(59, 130, 246, 0.4) !important;
    font-family: inherit !important;
}

.flatpickr-months {
    background: #1a1a1a !important;
    border-bottom: 1px solid #2a2a2a !important;
}

.flatpickr-current-month {
    color: #3b82f6 !important;
    font-weight: 600 !important;
}

.flatpickr-weekdays {
    background: #1a1a1a !important;
    border-bottom: 1px solid #2a2a2a !important;
}

.flatpickr-weekday {
    color: #888 !important;
    font-weight: 600 !important;
}

.flatpickr-day {
    color: #fff !important;
    border-radius: 8px !important;
    transition: all 0.2s ease !important;
}

.flatpickr-day:hover:not(.flatpickr-disabled) {
    background: rgba(59, 130, 246, 0.3) !important;
    border-color: #3b82f6 !important;
}

.flatpickr-day.selected,
.flatpickr-day.startRange,
.flatpickr-day.endRange {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    border-color: #3b82f6 !important;
    color: #fff !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4) !important;
}

.flatpickr-day.today {
    border-color: #3b82f6 !important;
    background: rgba(59, 130, 246, 0.15) !important;
}

.flatpickr-day.today:hover {
    background: rgba(59, 130, 246, 0.3) !important;
}

.flatpickr-months .flatpickr-prev-month,
.flatpickr-months .flatpickr-next-month {
    fill: #3b82f6 !important;
}

.flatpickr-months .flatpickr-prev-month:hover,
.flatpickr-months .flatpickr-next-month:hover {
    fill: #2563eb !important;
}

.flatpickr-day.flatpickr-disabled {
    color: #444 !important;
}

/* Inputs oscuros */
.form-control,
.form-select {
    background: #0f0f0f !important;
    border: 1px solid #2a2a2a !important;
    color: #fff !important;
    border-radius: 10px;
}
.form-control:focus,
.form-select:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
    background: #0f0f0f !important;
    color: #fff !important;
}

.form-control::placeholder {
    color: #666 !important;
}

.form-select option {
    background: #1a1a1a !important;
    color: #fff !important;
}
</style>

<script>
    // 🗓 Inicializar Flatpickr
    let flatpickrInstance;
    document.addEventListener("DOMContentLoaded", function() {
        flatpickrInstance = flatpickr("#task-date", {
            dateFormat: "d/m/Y",
            minDate: "today",
            locale: "es",
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    const date = selectedDates[0];
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    document.getElementById('task-date-hidden').value = `${year}-${month}-${day}`;
                }
            },
            onReady: function(dateObj, dateStr, instance) {
                document.getElementById('calendar-trigger').addEventListener('click', function() {
                    instance.open();
                });
            }
        });

        document.getElementById('task-date').addEventListener('blur', function(e) {
            const value = e.target.value;
            const regex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
            const match = value.match(regex);
            
            if (match) {
                const day = parseInt(match[1]);
                const month = parseInt(match[2]);
                const year = parseInt(match[3]);
                
                const date = new Date(year, month - 1, day);
                if (date.getDate() === day && date.getMonth() === month - 1 && date.getFullYear() === year) {
                    const yearStr = String(year);
                    const monthStr = String(month).padStart(2, '0');
                    const dayStr = String(day).padStart(2, '0');
                    document.getElementById('task-date-hidden').value = `${yearStr}-${monthStr}-${dayStr}`;
                    flatpickrInstance.setDate(date, false);
                } else {
                    alert('Fecha inválida. Por favor ingrese una fecha correcta.');
                    e.target.value = '';
                }
            } else if (value !== '') {
                alert('Formato de fecha incorrecto. Use DD/MM/AAAA');
                e.target.value = '';
            }
        });

        // BOTÓN ELIMINAR con SweetAlert
        document.querySelectorAll('.btn-delete-minimal').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const taskId = this.dataset.taskId;

                Swal.fire({
                    title: '¿Eliminar tarea?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    background: '#1a1a1a',
                    color: '#f3f4f6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Crear y enviar formulario de eliminación
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/tasks/${taskId}`;
                        
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        
                        form.appendChild(csrfInput);
                        form.appendChild(methodInput);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });

        // TOGGLE DE ESTADO - CORREGIDO
        document.querySelectorAll('.task-status-toggle').forEach(toggle => {
            toggle.addEventListener('change', function(e) {
                e.stopPropagation();
                const taskId = this.dataset.taskId;
                const isChecked = this.checked;
                const newStatusId = isChecked ? 3 : 1; // 3=Terminada, 1=Pendiente

                console.log('Cambiando estado:', { taskId, newStatusId, isChecked });

                fetch(`/tasks/${taskId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status_id: newStatusId })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    
                    if(data.success){
                        // Actualizar badge visual
                        const badge = document.querySelector(`#taskBadge${taskId}`);
                        if(badge){
                            badge.textContent = newStatusId == 3 ? 'Terminada' : 'Pendiente';
                            badge.className = `badge px-3 py-2 ${newStatusId == 3 ? 'bg-success' : 'bg-warning'}`;
                        }

                        // Actualizar el atributo data
                        this.dataset.currentStatus = newStatusId;

                        Swal.fire({
                            icon: 'success',
                            title: 'Estado actualizado',
                            text: `La tarea se ha marcado como ${newStatusId == 3 ? 'Terminada' : 'Pendiente'}`,
                            timer: 1500,
                            showConfirmButton: false,
                            background: '#1a1a1a',
                            color: '#f3f4f6',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error || 'No se pudo actualizar el estado',
                            background: '#1a1a1a',
                            color: '#f3f4f6',
                        });
                        this.checked = !this.checked; // Revertir toggle
                    }
                })
                .catch(error => {
                    console.error('Error en fetch:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el estado',
                        background: '#1a1a1a',
                        color: '#f3f4f6',
                    });
                    this.checked = !this.checked; // Revertir toggle
                });
            });
        });
    });

    // Nueva tarea
    function newTask() {
        document.getElementById('taskForm').action = "{{ route('tasks.store') }}";
        document.getElementById('formMethod').value = "POST";
        document.getElementById('modalTitle').textContent = "Agregar tarea";
        document.getElementById('taskForm').reset();
        document.getElementById('task-date').value = '';
        document.getElementById('task-date-hidden').value = '';
        if (flatpickrInstance) {
            flatpickrInstance.clear();
        }
    }

    // Editar tarea
    function editTask(taskId) {
        fetch(`/tasks/${taskId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const task = data.task;
                    document.getElementById('taskForm').action = `/tasks/${taskId}`;
                    document.getElementById('formMethod').value = "PUT";
                    document.getElementById('modalTitle').textContent = "Editar tarea";
                    document.getElementById('task-title').value = task.topic;
                    document.getElementById('task-desc').value = task.description || '';
                    document.getElementById('task-subject').value = task.subject_id;
                    
                    // Convertir formato de fecha YYYY-MM-DD a DD/MM/AAAA
                    const dateParts = task.due_date.split('-');
                    const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
                    document.getElementById('task-date').value = formattedDate;
                    document.getElementById('task-date-hidden').value = task.due_date;
                    
                    if (flatpickrInstance) {
                        flatpickrInstance.setDate(task.due_date, false);
                    }
                    
                    const modal = new bootstrap.Modal(document.getElementById('taskModal'));
                    modal.show();
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
@endpush

@endsection