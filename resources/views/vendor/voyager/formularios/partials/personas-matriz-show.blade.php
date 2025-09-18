<div class="panel panel-bordered panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-people"></i> PERSONAS AFECTADAS POR GRUPO ETARIO</h3>
    </div>
    <div class="panel-body">
        @php
            $afectados = $formulario->afectadosIncendios->keyBy('grupo_etario_id');
            // Totales por columna
            $totalAfectados  = $formulario->afectadosIncendios->sum('cantidad_afectados');
            $totalLesionados = $formulario->afectadosIncendios->sum('cantidad_lesionados');
            $totalFallecidos = $formulario->afectadosIncendios->sum('cantidad_fallecidos');
        @endphp
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Grupo etario</th>
                        <th>Afectados</th>
                        <th>Lesionados</th>
                        <th>Fallecidos</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupoEtarios as $grupo)
                        @php
                            $af = $afectados->get($grupo->id);
                            $subTotal = ($af?->cantidad_afectados ?? 0) +
                                        ($af?->cantidad_lesionados ?? 0) +
                                        ($af?->cantidad_fallecidos ?? 0);
                        @endphp
                        <tr>
                            <td>{{ $grupo->nombre }}</td>
                            <td>{{ $af?->cantidad_afectados ?? 0 }}</td>
                            <td>{{ $af?->cantidad_lesionados ?? 0 }}</td>
                            <td>{{ $af?->cantidad_fallecidos ?? 0 }}</td>
                            <td class="text-center active"><strong>{{ $subTotal }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="active">
                        <th>Total general</th>
                        <th>{{ $totalAfectados }}</th>
                        <th>{{ $totalLesionados }}</th>
                        <th>{{ $totalFallecidos }}</th>
                        <th class="text-center">{{ $totalAfectados + $totalLesionados + $totalFallecidos }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <strong>Total general de personas afectadas:</strong> {{ $totalAfectados + $totalLesionados + $totalFallecidos }}
            </div>
        </div>
    </div>
</div>
