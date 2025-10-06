@extends('layouts.tabler')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
                <h1 class="mb-2" style="font-size: 42px; font-weight: 800; background: linear-gradient(135deg, #3b82f6, #2563eb); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="ti ti-flame"></i> Materias
                </h1>
            <p class="text-light">Gestiona tus materias y sus tareas asociadas</p>
        </div>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-lg">
            <i class="ti ti-plus me-2"></i> Nueva Materia
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($subjects as $subject)
            <div class="col-md-4 mb-4">
                <div class="card h-100" style="background: linear-gradient(145deg, #1c1c1c, #242424); border: 1px solid #2c2c2c; border-radius: 15px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="card-title text-white mb-1">
                                    <i class="ti ti-book text-primary me-2"></i>
                                    {{ $subject->name }}
                                </h3>
                                <span class="badge {{ $subject->status ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                    {{ $subject->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-ghost-light btn-icon" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('subjects.edit', $subject) }}" class="dropdown-item">
                                        <i class="ti ti-edit me-2"></i> Editar
                                    </a>
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta materia?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="ti ti-trash me-2"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <p class="text-muted mb-3">
                            {{ $subject->description ?: 'Sin descripción' }}
                        </p>

                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    <i class="ti ti-clipboard-check me-1"></i>
                                    {{ $subject->tasks_count }} tareas
                                </div>
                                <a href="#" class="btn btn-ghost-primary btn-sm">
                                    <i class="ti ti-eye me-1"></i>
                                    Ver tareas
                                </a>
                            </div>

                            <div class="d-flex gap-2 justify-content-end mt-2 border-top pt-3">
                                <a href="{{ route('subjects.edit', $subject) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="ti ti-edit me-1"></i>
                                    Editar
                                </a>
                                <form action="{{ route('subjects.destroy', $subject) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta materia? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="ti ti-trash me-1"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card" style="background: linear-gradient(145deg, #1c1c1c, #242424); border: 1px solid #2c2c2c;">
                    <div class="card-body text-center py-5">
                        <img src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.54.0/icons/mood-empty.svg" 
                             class="mb-3" width="64" height="64" alt="No hay materias">
                        <h3 class="text-white">No hay materias registradas</h3>
                        <p class="text-muted">Comienza creando tu primera materia</p>
                        <a href="{{ route('subjects.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-2"></i>
                            Crear materia
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación suave al mostrar las tarjetas
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
@endsection