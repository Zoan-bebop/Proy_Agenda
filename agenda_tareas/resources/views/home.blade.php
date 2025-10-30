@extends('layouts.app')

@section('title', 'Mi Agenda')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.css">
<style>
    .fc .fc-toolbar-title {
        font-size: 1.2rem;
    }
    .fc .fc-button {
        padding: 0.3rem 0.6rem;
        font-size: 0.875rem;
    }
    .task-list {
        max-height: 400px;
        overflow-y: auto;
    }
    .materias-list .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
</style>
@endpush

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Mi Agenda de Tareas</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-task">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Agregar Tarea
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Calendario -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendario de Tareas</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Sidebar derecho -->
        <div class="col-md-4">
            <!-- Materias -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Materias</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush materias-list">
                        @foreach(['Matemáticas' => '#206bc4', 'Física' => '#2fb344', 'Química' => '#f59f00', 'Literatura' => '#e83e8c'] as $materia => $color)
                        <a href="#" class="list-group-item list-group-item-action">
                            <span class="status-dot" style="background-color: {{ $color }}"></span>
                            {{ $materia }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tareas Próximas -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tareas Próximas</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush task-list">
                        @foreach(['Entregar Proyecto Final', 'Preparar Presentación', 'Examen Parcial'] as $tarea)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-truncate">{{ $tarea }}</div>
                                    <div class="text-light small">Vence en 3 días</div>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-primary">Pendiente</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Tarea -->
<div class="modal modal-blur fade" id="modal-task" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Título de la tarea</label>
                    <input type="text" class="form-control" placeholder="Ej: Entregar proyecto final">
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Materia</label>
                            <select class="form-select">
                                <option value="1">Matemáticas</option>
                                <option value="2">Física</option>
                                <option value="3">Química</option>
                                <option value="4">Literatura</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Fecha de entrega</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" rows="3" placeholder="Describe los detalles de la tarea..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Guardar tarea</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        events: [
            {
                title: 'Entrega Proyecto',
                start: '2025-10-31',
                backgroundColor: '#206bc4'
            },
            {
                title: 'Examen Final',
                start: '2025-11-15',
                backgroundColor: '#2fb344'
            }
        ],
        locale: 'es',
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana'
        }
    });
    calendar.render();
});
</script>
@endpush
@endsection
