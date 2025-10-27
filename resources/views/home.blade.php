@extends('layouts.public')

@section('title', 'Dashboard Público de Incendios')

@push('css')
<style>
    .stat-card {
        border-left: 5px solid #007bff;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .stat-card .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #6c757d;
    }
    .stat-card .card-text {
        font-size: 2.5rem;
        font-weight: 700;
        color: #343a40;
    }
    #mapaIncendios {
        height: 500px;
        border-radius: .25rem;
        border: 1px solid #ddd;
    }
    .chart-container {
        height: 350px;
    }
</style>
@endpush

@section('content')
    <div class="jumbotron bg-white text-center">
        <h1 class="display-4">Estado de Incendios en el Beni</h1>
        <p class="lead">Información actualizada sobre los incendios forestales y las acciones de respuesta en el departamento.</p>
        <hr class="my-4">
        <p>Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    {{-- 1. Tarjetas de Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card h-100" style="border-color: #dc3545;">
                <div class="card-body">
                    <h5 class="card-title">INCENDIOS ACTIVOS</h5>
                    <p class="card-text">{{ $stats['incendios_activos'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card h-100" style="border-color: #ffc107;">
                <div class="card-body">
                    <h5 class="card-title">FAMILIAS AFECTADAS</h5>
                    <p class="card-text">{{ number_format($stats['familias_afectadas'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card h-100" style="border-color: #28a745;">
                <div class="card-body">
                    <h5 class="card-title">HECTÁREAS AFECTADAS</h5>
                    <p class="card-text">{{ number_format($stats['ha_afectadas'] ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card h-100" style="border-color: #17a2b8;">
                <div class="card-body">
                    <h5 class="card-title">FORMULARIOS TOTALES</h5>
                    <p class="card-text">{{ $stats['formularios_total'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Mapa de Incendios --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title mb-0">📍 Mapa de Incendios Activos y Controlados</h3>
        </div>
        <div class="card-body">
            <div id="mapaIncendios"></div>
        </div>
    </div>

    {{-- 3. Gráficos --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h3 class="card-title mb-0">📊 Incendios por Gravedad</h3>
                </div>
                <div class="card-body chart-container">
                    <canvas id="chartGravedad"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h3 class="card-title mb-0">📈 Reportes por Mes (Último Año)</h3>
                </div>
                <div class="card-body chart-container">
                    <canvas id="chartFormulariosMes"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Últimos Reportes Registrados --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title mb-0">📝 Últimos Reportes Registrados</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Código</th>
                            <th>Fecha de Reporte</th>
                            <th>Comunidad</th>
                            <th>Municipio</th>
                            <th>Estado del Incendio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimosFormularios as $form)
                        <tr>
                            <td>{{ $form->codigo_formulario }}</td>
                            <td>{{ $form->fecha_llenado->format('d/m/Y') }}</td>
                            <td>{{ optional($form->comunidad)->nombre ?? 'N/A' }}</td>
                            <td>{{ optional($form->comunidad->municipio)->nombre ?? 'N/A' }}</td>
                            <td>
                                @if($form->incendio)
                                    <span class="badge badge-pill badge-{{ $form->incendio->estado == 'activo' ? 'danger' : ($form->incendio->estado == 'controlado' ? 'warning' : 'success') }}">
                                        {{ ucfirst($form->incendio->estado) }}
                                    </span>
                                @else
                                    <span class="badge badge-pill badge-secondary">Sin datos</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay reportes recientes.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- MAPA DE INCENDIOS ---
    const incendios = @json($incendiosParaMapa);
    // Coordenadas centradas en el departamento del Beni, Bolivia
    const map = L.map('mapaIncendios').setView([-14.45, -65.40], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const fireIconActivo = L.icon({
        iconUrl: 'https://img.icons8.com/plasticine/100/000000/fire-element.png',
        iconSize: [38, 38],
    });

    const fireIconControlado = L.icon({
        iconUrl: 'https://img.icons8.com/color/96/000000/fire-extinguisher.png',
        iconSize: [35, 35],
    });

    incendios.forEach(incendio => {
        const icon = incendio.estado === 'activo' ? fireIconActivo : fireIconControlado;
        const marker = L.marker([incendio.lat, incendio.lon], { icon: icon }).addTo(map);

        const popupContent = `
            <b>Código:</b> ${incendio.codigo_incendio}<br>
            <b>Estado:</b> <span style="text-transform: capitalize; font-weight: bold; color: ${incendio.estado === 'activo' ? 'red' : 'orange'}">${incendio.estado}</span><br>
            <b>Gravedad:</b> ${incendio.nivel_gravedad}<br>
            <b>Fecha Inicio:</b> ${new Date(incendio.fecha_inicio).toLocaleString()}
        `;
        marker.bindPopup(popupContent);
    });

    // --- GRÁFICO DE GRAVEDAD (Dona) ---
    const dataGravedad = @json($stats['incendios_por_gravedad'] ?? []);
    const ctxGravedad = document.getElementById('chartGravedad').getContext('2d');
    new Chart(ctxGravedad, {
        type: 'doughnut',
        data: {
            labels: Object.keys(dataGravedad).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                label: 'Incendios por Gravedad',
                data: Object.values(dataGravedad),
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)', // bajo
                    'rgba(255, 206, 86, 0.7)', // medio
                    'rgba(255, 159, 64, 0.7)', // alto
                    'rgba(255, 99, 132, 0.7)'  // critico
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // --- GRÁFICO DE FORMULARIOS POR MES (Barras) ---
    const dataFormularios = @json($stats['formularios_por_mes'] ?? []);
    const ctxFormularios = document.getElementById('chartFormulariosMes').getContext('2d');
    new Chart(ctxFormularios, {
        type: 'bar',
        data: {
            labels: Object.keys(dataFormularios),
            datasets: [{
                label: 'N° de Reportes',
                data: Object.values(dataFormularios),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Asegura que el eje Y solo muestre números enteros
                        callback: function(value) {if (value % 1 === 0) {return value;}}
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endpush
