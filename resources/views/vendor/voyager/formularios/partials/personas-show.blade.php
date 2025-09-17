<div class="panel panel-bordered panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-people"></i> PERSONAS AFECTADAS</h3>
    </div>
    <div class="panel-body">
        @php
            $registro = $formulario->afectadosIncendios->first();
            $salud    = $formulario->salud->first();
        @endphp

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Grupo etario</th>
                    <th>Afectados</th>
                    <th>Fallecidos</th>
                    <th>Lesionados</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ optional($registro)->grupoEtario->nombre ?? 'No registrado' }}</td>
                    <td>{{ optional($registro)->cantidad_afectados ?? 0 }}</td>
                    <td>{{ optional($registro)->cantidad_fallecidos ?? 0 }}</td>
                    <td>{{ optional($registro)->cantidad_lesionados ?? 0 }}</td>
                </tr>
            </tbody>
        </table>

        @if($salud)
            <h4 class="mt-3"><i class="voyager-heart"></i> SALUD</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Enfermedad</th>
                        <th>Cantidad enfermos</th>
                        <th>Gravedad promedio</th>
                        <th>Tratamiento requerido</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ optional($salud->enfermedad)->nombre ?? 'No registrado' }}</td>
                        <td>{{ $salud->cantidad_enfermos ?? 0 }}</td>
                        <td>{{ $salud->gravedad_promedio ?? 'No registrado' }}</td>
                        <td>{{ $salud->tratamiento_requerido ?? 'No registrado' }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se registraron datos de salud.</p>
        @endif
    </div>
</div>
