<div class="panel panel-bordered panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-documentation"></i> REPORTE GENERAL</h3>
    </div>
    <div class="panel-body">
        @php $reporte = $formulario->reporteComunitario @endphp

        @if($reporte)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Incendios registrados</th>
                        <td>{{ $reporte->incendios_registrados ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Incendios activos</th>
                        <td>{{ $reporte->incendios_activos ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Familias afectadas</th>
                        <td>{{ $reporte->num_familias_afectadas ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Familias damnificadas</th>
                        <td>{{ $reporte->num_familias_damnificadas ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Personas evacuadas</th>
                        <td>{{ $reporte->num_personas_evacuadas ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Necesidades</th>
                        <td>{{ $reporte->necesidades ?? 'No registradas' }}</td>
                    </tr>
                    <tr>
                        <th>Ayuda recibida</th>
                        <td>{{ $reporte->ayuda_recibida ?? 'No registrada' }}</td>
                    </tr>
                    <tr>
                        <th>Vías de acceso afectadas</th>
                        <td>{{ $reporte->vias_acceso_afectadas ?? 'No registradas' }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se ha registrado reporte general.</p>
        @endif
    </div>
</div>
