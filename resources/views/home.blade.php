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
    {{-- Jumbotron --}}
    @include('partials.jumbotron')

    {{-- 1. Tarjetas de Estadísticas --}}
    <section class="mb-4" aria-label="Estadísticas rápidas">
        @include('partials.stats', ['stats' => $stats])
    </section>

    {{-- 2. Mapa de Incendios --}}
    <section class="mb-4" aria-label="Mapa de incendios">
        @include('partials.map')
    </section>

    {{-- 3. Gráficos --}}
    <section class="mb-4" aria-label="Gráficos de datos">
        @include('partials.charts')
    </section>

    {{-- 4. Últimos Reportes Registrados --}}
    <section aria-label="Últimos reportes">
        @include('partials.latest_reports', ['ultimosFormularios' => $ultimosFormularios])
    </section>
@endsection

@push('javascript')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- MAPA DE INCENDIOS ---
    const incendios = @json($incendiosParaMapa);
    // Coordenadas centradas en el departamento del Beni, Bolivia
    const map = L.map('mapaIncendios').setView([-13.45, -65.40], 7);

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

    // --- GRÁFICO DE PÉRDIDAS POR SECTOR (Pie) ---
    const dataPerdidas = @json($stats['perdidas_por_sector'] ?? []);
    const ctxPerdidas = document.getElementById('chartPerdidasSector').getContext('2d');
    new Chart(ctxPerdidas, {
        type: 'pie',
        data: {
            labels: Object.keys(dataPerdidas).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                label: 'Pérdidas por Sector',
                data: Object.values(dataPerdidas),
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',  // Agrícola
                    'rgba(253, 126, 20, 0.7)', // Pecuario
                    'rgba(108, 117, 125, 0.7)',// Forestal
                    'rgba(220, 53, 69, 0.7)',  // Infraestructura
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
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            return `${label}: ${new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB' }).format(value)}`;
                        }
                    }
                }
            }
        }
    });

    // --- GRÁFICO DE FORMULARIOS POR MES (Barras) ---
    const dataFormularios = @json($stats['reportes_por_mes'] ?? []);
    const ctxFormularios = document.getElementById('chartReportesMes').getContext('2d');
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
