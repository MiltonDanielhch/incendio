<div class="panel panel-bordered panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-basket"></i> ASISTENCIA</h3>
    </div>
    <div class="panel-body">
        @php $asist = $formulario->asistencias->first() @endphp

        @if($asist)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Tipo de asistencia</th>
                        <td>{{ optional($asist->tipoAsistencia)->nombre ?? 'No registrado' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de asistencia</th>
                        <td>{{ optional($asist->fecha_asistencia)->format('d/m/Y') ?? 'No registrada' }}</td>
                    </tr>
                    <tr>
                        <th>Organización proveedora</th>
                        <td>{{ $asist->organizacion_proveedora ?? 'No registrada' }}</td>
                    </tr>
                    <tr>
                        <th>Actividades</th>
                        <td>{{ $asist->actividades ?? 'No registradas' }}</td>
                    </tr>
                    <tr>
                        <th>Cantidad de beneficiarios</th>
                        <td>{{ number_format($asist->cantidad_beneficiarios, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Valor de la asistencia</th>
                        <td>$ {{ number_format($asist->valor_asistencia, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se han registrado actividades de asistencia.</p>
        @endif
    </div>
</div>
