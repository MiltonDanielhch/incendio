<div class="panel panel-bordered panel-info" style="margin-top: 15px;">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-heart"></i> SALUD POR ENFERMEDAD</h3>
    </div>
    <div class="panel-body">
        @php
            // Agrupamos por enfermedad
            $saludPorEnf = $formulario->salud->groupBy('catalogo_id');

            // Totales por grupo etario
            $totalPorGrupo = collect();
            foreach ($grupoEtarios as $g) {
                $totalPorGrupo[$g->id] = $formulario->salud
                    ->where('grupo_etario_id', $g->id)
                    ->sum('cantidad_enfermos');
            }
        @endphp

        <div class="table-responsive table-striped">
            <table class="table" role="table" aria-labelledby="saludTable">
                <thead>
                    <tr>
                        <th>Enfermedad</th>
                        @foreach($grupoEtarios as $grupo)
                            <th class="text-center">{{ $grupo->nombre }}</th>
                        @endforeach
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enfermedades as $enf)
                        @php
                            $registros = $saludPorEnf->get($enf->id, collect());
                            $totalFila = $registros->sum('cantidad_enfermos');
                        @endphp
                        <tr>
                            <td>{{ $enf->nombre }}</td>
                            @foreach($grupoEtarios as $grupo)
                                @php
                                    $reg = $registros->firstWhere('grupo_etario_id', $grupo->id);
                                @endphp
                                <td class="text-center">
                                    <div class="badge badge-primary mb-1">
                                        {{ $reg?->cantidad_enfermos ?? 0 }}
                                    </div>
                                    <br>
                                    <small class="text-muted">G: {{ $reg?->gravedad_promedio ?? '—' }}</small>
                                    <br>
                                    <small class="d-block" title="{{ $reg?->tratamiento_requerido ?? '' }}">
                                        {{ \Illuminate\Support\Str::limit($reg?->tratamiento_requerido, 15) }}
                                    </small>
                                </td>
                            @endforeach
                            <td class="text-center active">
                                <strong>{{ $totalFila }}</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="active">
                        <th>Total por grupo</th>
                        @foreach($grupoEtarios as $grupo)
                            <th class="text-center">{{ $totalPorGrupo[$grupo->id] }}</th>
                        @endforeach
                        <th class="text-center">{{ $formulario->salud->sum('cantidad_enfermos') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <strong>Total general de enfermos:</strong> {{ $formulario->salud->sum('cantidad_enfermos') }}
            </div>
        </div>
    </div>
</div>
