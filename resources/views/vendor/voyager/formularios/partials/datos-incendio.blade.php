<h4>🔥 Datos del incendio</h4>
<table class="table table-bordered">
    <tr><th width="200">Código incendio</th><td>{{ $formulario->incendio->codigo_incendio }}</td></tr>
    <tr><th>Inicio</th><td>{{ $formulario->incendio->fecha_inicio->format('d/m/Y H:i') }}</td></tr>
    <tr><th>Fin</th><td>{{ $formulario->incendio->fecha_fin?->format('d/m/Y H:i') ?? 'No finalizado' }}</td></tr>
    <tr><th>Estado</th><td><span class="label label-{{ $formulario->incendio->estado == 'extinguido' ? 'success' : 'warning' }}">{{ ucfirst($formulario->incendio->estado) }}</span></td></tr>
    <tr><th>Gravedad</th><td><span class="label label-{{ $formulario->incendio->nivel_gravedad == 'crítico' ? 'danger' : 'primary' }}">{{ ucfirst($formulario->incendio->nivel_gravedad) }}</span></td></tr>
    <tr><th>Área afectada</th><td>{{ $formulario->incendio->area_afectada_ha ?: 'No registrada' }} ha</td></tr>
    <tr><th>Causas probables</th><td>{{ $formulario->incendio->causas_probables ?: 'No registradas' }}</td></tr>
    <tr><th>Observaciones</th><td>{{ $formulario->incendio->observaciones ?: 'Sin observaciones' }}</td></tr>
</table>
