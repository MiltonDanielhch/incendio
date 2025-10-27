<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100" style="border-color: #dc3545;" aria-label="Total de incendios activos actualmente">
            <div class="card-body">
                <h5 class="card-title">INCENDIOS ACTIVOS</h5>
                <p class="card-text">{{ $stats['incendios_activos'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100" style="border-color: #28a745;" aria-label="Total de hectáreas afectadas">
            <div class="card-body">
                <h5 class="card-title">HECTÁREAS AFECTADAS</h5>
                <p class="card-text">{{ number_format($stats['ha_afectadas'] ?? 0, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100" style="border-color: #ffc107;" aria-label="Total de personas afectadas">
            <div class="card-body">
                <h5 class="card-title">PERSONAS AFECTADAS</h5>
                <p class="card-text">{{ number_format($stats['total_personas_afectadas'] ?? 0) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100" style="border-color: #6f42c1;" aria-label="Pérdida económica total estimada en Bolivianos">
            <div class="card-body">
                <h5 class="card-title">PÉRDIDA ECONÓMICA (Bs.)</h5>
                <p class="card-text" style="font-size: 1.8rem;">{{ number_format($stats['perdida_economica_total'] ?? 0, 2) }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100" style="border-color: #fd7e14;" aria-label="Total de familias afectadas">
            <div class="card-body">
                <h5 class="card-title">FAMILIAS AFECTADAS</h5>
                <p class="card-text">{{ number_format($stats['familias_afectadas'] ?? 0) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100" style="border-color: #20c997;" aria-label="Total de comunidades afectadas">
            <div class="card-body">
                <h5 class="card-title">COMUNIDADES AFECTADAS</h5>
                <p class="card-text">{{ number_format($stats['comunidades_afectadas'] ?? 0) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100" style="border-color: #17a2b8;" aria-label="Total de formularios de evaluación registrados">
            <div class="card-body">
                <h5 class="card-title">FORMULARIOS REGISTRADOS</h5>
                <p class="card-text">{{ $stats['formularios_total'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card h-100" style="border-color: #343a40;" aria-label="Total de personas fallecidas">
            <div class="card-body">
                <h5 class="card-title">PERSONAS FALLECIDAS</h5>
                <p class="card-text">{{ number_format($stats['total_personas_fallecidas'] ?? 0) }}</p>
            </div>
        </div>
    </div>
</div>
