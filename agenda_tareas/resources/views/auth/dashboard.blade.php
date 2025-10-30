@extends('layouts.tabler')

@section('title', 'Estadísticas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-5">
        <h1 class="mb-2" style="font-size: 42px; font-weight: 800; background: linear-gradient(135deg, #3b82f6, #2563eb); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Panel de Estadísticas
        </h1>
        <p class="text-light">Visualiza tu productividad y progreso académico</p>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-5">
        @php
            $cards = [
                ['title' => 'Total de Tareas', 'count' => $totalTasks, 'color' => '#3b82f6', 'icon' => 'ti-clipboard-check', 'text' => 'Actualizado', 'textColor' => 'text-success', 'bg' => 'rgba(59, 130, 246, 0.2)'],
                ['title' => 'Completadas', 'count' => $completedTasks, 'color' => '#10b981', 'icon' => 'ti-circle-check', 'text' => ($totalTasks > 0 ? round(($completedTasks/$totalTasks)*100).'% ' : '0% ').'éxito', 'textColor' => 'text-success', 'bg' => 'rgba(16, 185, 129, 0.2)'],
                ['title' => 'Pendientes', 'count' => $pendingTasks, 'color' => '#f59e0b', 'icon' => 'ti-clock', 'text' => 'Por completar', 'textColor' => 'text-warning', 'bg' => 'rgba(245, 158, 11, 0.2)'],
                ['title' => 'No Completadas', 'count' => $notCompletedTasks, 'color' => '#ef4444', 'icon' => 'ti-x', 'text' => 'Requiere Atención', 'textColor' => 'text-danger', 'bg' => 'rgba(239, 68, 68, 0.2)'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card task-card p-4 border-0" style="border-left: 4px solid {{ $card['color'] }} !important; min-height: 170px;">
                    <div class="d-flex justify-content-between align-items-start h-100">
                        <div class="d-flex flex-column justify-content-between flex-grow-1" style="min-height: 130px;">
                            <div>
                                <p class="text-light mb-2 small text-uppercase" style="line-height: 1.2;">{{ $card['title'] }}</p>
                                <h2 class="mb-0" style="color: {{ $card['color'] }}; font-weight: 700; font-size: 2.5rem; line-height: 1;">{{ $card['count'] }}</h2>
                            </div>
                            <p class="mb-0 small {{ $card['textColor'] }}" style="line-height: 1.3;">
                                <i class="ti ti-trending-up"></i> {{ $card['text'] }}
                            </p>
                        </div>
<div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 70px; height: 70px; background: {{ $card['bg'] }}; border-radius: 16px;"> <i class="ti {{ $card['icon'] }}" style="font-size: 36px; color: {{ $card['color'] }}"></i> </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card task-card p-4 border-0">
                <h5 class="mb-4" style="color: #fff; font-weight: 700; font-size: 1.25rem;">
                    <i class="ti ti-chart-pie me-2" style="color: #3b82f6;"></i>Distribución de Tareas
                </h5>
                <canvas id="pieChart" height="250"></canvas>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card task-card p-4 border-0">
                <h5 class="mb-4" style="color: #fff; font-weight: 700; font-size: 1.25rem;">
                    <i class="ti ti-chart-bar me-2" style="color: #3b82f6;"></i>Tareas por Materia
                </h5>
                <canvas id="barChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Line Chart -->
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card task-card p-4 border-0">
                <h5 class="mb-4" style="color: #fff; font-weight: 700; font-size: 1.25rem;">
                    <i class="ti ti-chart-line me-2" style="color: #3b82f6;"></i>Productividad Semanal
                </h5>
                <canvas id="lineChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card task-card p-4 border-0">
                <h5 class="mb-4" style="color: #fff; font-weight: 700; font-size: 1.25rem;">
                    <i class="ti ti-history me-2" style="color: #3b82f6;"></i>Actividad Reciente
                </h5>
                <div class="list-group list-group-flush">
                    @forelse($recentActivities as $task)
                        <div class="list-group-item bg-transparent border-0 text-white d-flex align-items-center gap-3 py-3" style="border-bottom: 1px solid #2a2a2a !important;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: {{ $task->status->name == 'Terminada' ? 'rgba(16, 185, 129, 0.2)' : ($task->status->name == 'Pendiente' ? 'rgba(245, 158, 11, 0.2)' : 'rgba(239, 68, 68, 0.2)') }};">
                                <i class="ti {{ $task->status->name == 'Terminada' ? 'ti-check' : ($task->status->name == 'Pendiente' ? 'ti-clock' : 'ti-alert-triangle') }}" style="color: {{ $task->status->name == 'Terminada' ? '#10b981' : ($task->status->name == 'Pendiente' ? '#f59e0b' : '#ef4444') }}; font-size: 24px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-semibold" style="font-size: 1rem;">{{ $task->topic }}</p>
                                <small class="text-light">
                                    <i class="ti ti-book me-1"></i>{{ $task->subject->name ?? 'Sin materia' }} • 
                                    <i class="ti ti-clock me-1"></i>{{ $task->updated_at->diffForHumans() }}
                                </small>
                            </div>
                            <span class="badge {{ $task->status->name == 'Terminada' ? 'bg-success' : ($task->status->name == 'Pendiente' ? 'bg-warning' : 'bg-danger') }}">
                                {{ $task->status->name }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center text-light py-4">
                            <i class="ti ti-inbox" style="font-size: 48px;"></i>
                            <p class="mt-2">No hay actividad reciente</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)';

    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($pieData)) !!},
            datasets: [{
                data: {!! json_encode(array_values($pieData)) !!},
                backgroundColor: ['rgba(16, 185, 129, 0.8)','rgba(245, 158, 11, 0.8)','rgba(239, 68, 68, 0.8)'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true, font: { size: 13, weight: '600' } } },
                tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, cornerRadius: 8 }
            }
        }
    });

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($barLabels) !!},
            datasets: [{
                label: 'Tareas',
                data: {!! json_encode($barData) !!},
                backgroundColor: ['rgba(59, 130, 246, 0.8)','rgba(16, 185, 129, 0.8)','rgba(245, 158, 11, 0.8)','rgba(139, 92, 246, 0.8)','rgba(236, 72, 153, 0.8)'],
                borderRadius: 10,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.05)' } }, x: { grid: { display: false } } },
            plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, cornerRadius: 8 } }
        }
    });

    // Line Chart
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($weekDays) !!},
            datasets: [{
                label: 'Tareas Completadas',
                data: {!! json_encode($weekData) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, cornerRadius: 8 } },
            scales: { y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.05)' } }, x: { grid: { display: false } } }
        }
    });
</script>
@endpush