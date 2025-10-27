<div class="card shadow-sm">
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
                                <span class="badge badge-pill badge-{{ $form->incendio->estado == 'activo' ? 'danger' : ($form->incendio->estado == 'controlado' ? 'warning' : 'success') }}">{{ ucfirst($form->incendio->estado) }}</span>
                            @else
                                <span class="badge badge-pill badge-secondary">Sin datos</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">No hay reportes recientes.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
