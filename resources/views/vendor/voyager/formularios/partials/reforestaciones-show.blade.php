<div class="panel panel-bordered panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-tree"></i> REFORESTACIÓN</h3>
    </div>
    <div class="panel-body">
        @php $reforest = $formulario->reforestaciones->first() @endphp

        @if($reforest)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Especie de plantín</th>
                        <td>{{ optional($reforest->catalogo)->nombre ?? 'No registrada' }}</td>
                    </tr>
                    <tr>
                        <th>Cantidad de plantines</th>
                        <td>{{ number_format($reforest->cantidad_plantines, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Área reforestada</th>
                        <td>{{ number_format($reforest->area_reforestada_ha, 2) }} ha</td>
                    </tr>
                    <tr>
                        <th>Fecha de reforestación</th>
                        <td>{{ optional($reforest->fecha_reforestacion)->format('d/m/Y') ?? 'No registrada' }}</td>
                    </tr>
                    <tr>
                        <th>Supervivencia estimada</th>
                        <td>{{ number_format($reforest->supervivencia_estimada_porcentaje, 2) }} %</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se han registrado actividades de reforestación.</p>
        @endif
    </div>
</div>
