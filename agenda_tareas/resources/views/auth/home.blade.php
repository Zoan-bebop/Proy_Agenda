@extends('layouts.tabler')

@section('title', 'Panel de Tareas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-white">Panel Principal</h2>

    <div class="d-flex align-items-center gap-3">
        {{-- 👤 Botón de administrador (solo si rol == 1) --}}
        @if(Auth::check() && Auth::user()->rol == 1)
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                <i class="ti ti-user-cog"></i> Admin
            </a>
        @endif
    </div>
</div>
<div class="container-fluid">

    {{-- 🧭 Barra superior de filtros --}}
    <div class="d-flex justify-content-center gap-3 mb-4">
        <button class="btn btn-outline-primary active px-4 py-2" id="btn-pendiente">Pendiente</button>
        <button class="btn btn-outline-primary px-4 py-2" id="btn-completado">Completado</button>
        <button class="btn btn-outline-primary px-4 py-2" id="btn-nocompletado">No completado</button>
    </div>

    {{-- 🧾 Lista de tareas --}}
    <h1 class="mb-4 text-white text-center">Mis Tareas</h1>
    

    <div class="row" id="task-list">
        @for ($i = 1; $i <= 5; $i++)
            <div class="col-12 mb-3">
                <div class="card task-card p-3" data-bs-toggle="modal" data-bs-target="#taskModal">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white">Tarea {{ $i }}</h3>
                            
                            <p class="text-muted mb-0">Descripción breve de la tarea {{ $i }}</p>
                        </div>
                        <span class="badge bg-primary">Pendiente</span>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    {{-- ➕ Botón agregar tarea --}}
    <div class="text-center mt-4">
        <button class="btn btn-primary px-5 py-2" data-bs-toggle="modal" data-bs-target="#taskModal">
            <i class="ti ti-plus"></i> Agregar tarea
        </button>
    </div>
</div>

{{-- 🪟 Modal de tarea --}}
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background-color:#1c1c1c; border:1px solid #2c2c2c;">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="taskModalLabel">Agregar / Editar tarea</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="task-title" class="form-label text-white">Título</label>
            <input type="text" class="form-control" id="task-title" placeholder="Ej. Ensayo de Literatura">
          </div>
          <div class="mb-3">
            <label for="task-desc" class="form-label text-white">Descripción</label>
            <textarea class="form-control" id="task-desc" rows="3" placeholder="Detalles de la tarea..."></textarea>
          </div>
          <div class="mb-3">
            <label for="task-date" class="form-label text-white">Fecha límite</label>
            <input type="date" class="form-control" id="task-date">
          </div>
          <div class="mb-3">
            <label for="task-subject" class="form-label text-white">Materia</label>
            <select id="task-subject" class="form-select">
              <option selected>Seleccionar materia</option>
              <option>Matemáticas</option>
              <option>Historia</option>
              <option>Física</option>
              <option>Lenguaje</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer border-top border-secondary">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar tarea</button>
      </div>
    </div>
  </div>
</div>

{{--  Estilos y activación visual --}}
@push('scripts')
<script>
    const buttons = document.querySelectorAll('.btn-outline-primary');
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
</script>
<style>
    .btn-outline-primary {
        border-color: #3b82f6;
        color: #3b82f6;
        background-color: transparent;
        transition: all 0.2s ease;
    }
    .btn-outline-primary:hover {
        background-color: #3b82f6;
        color: #fff;
    }
    .btn-outline-primary.active {
        background-color: #3b82f6;
        color: #fff;
    }
</style>
@endpush

@endsection
