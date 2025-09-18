<div class="panel panel-bordered panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-dollar"></i> IMPACTO ECONÓMICO</h3>
    </div>
    <div class="panel-body">

        {{-- SECTOR AGRÍCOLA --}}
        @php $agricola = $formulario->sectoresAgricolas->first(); @endphp
        <h4><i class="voyager-bag"></i> Sector agrícola</h4>
        @if($agricola)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Cultivo</th>
                        <td>{{ optional($agricola->cultivo)->nombre ?? 'No registrado' }}</td>

                    </tr>
                    <tr>
                        <th>Has afectadas</th>
                        <td>{{ number_format($agricola->ha_afectadas, 2) }} ha</td>
                    </tr>
                    <tr>
                        <th>Has pérdidas totales</th>
                        <td>{{ number_format($agricola->ha_perdidas, 2) }} ha</td>
                    </tr>
                    <tr>
                        <th>Producción estimada afectada</th>
                        <td>{{ number_format($agricola->produccion_estimada_kg, 0, ',', '.') }} kg</td>
                    </tr>
                    <tr>
                        <th>Valor pérdida</th>
                        <td>$ {{ number_format($agricola->valor_estimado_perdida, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se registraron daños agrícolas.</p>
        @endif

        {{-- SECTOR PECUARIO --}}
        @php $pecuario = $formulario->sectoresPecuarios->first(); @endphp
        <h4><i class="voyager-bag"></i> Sector pecuario</h4>
        @if($pecuario)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Especie</th>
                        <td>{{ optional($pecuario->especie)->nombre ?? 'No registrado' }}</td>
                    </tr>
                    <tr>
                        <th>Afectados</th>
                        <td>{{ $pecuario->numero_animales_afectados }}</td>
                    </tr>
                    <tr>
                        <th>Fallecidos</th>
                        <td>{{ $pecuario->numero_animales_fallecidos }}</td>
                    </tr>
                    <tr>
                        <th>Evacuados</th>
                        <td>{{ $pecuario->numero_animales_evacuados }}</td>
                    </tr>
                    <tr>
                        <th>Valor pérdida</th>
                        <td>$ {{ number_format($pecuario->valor_estimado_perdida, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se registraron daños pecuarios.</p>
        @endif

        {{-- ÁREAS FORESTALES --}}
        @php $forestal = $formulario->areasForestales->first(); @endphp
        <h4><i class="voyager-tree"></i> Áreas forestales</h4>
        @if($forestal)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Tipo de área</th>
                        <td>{{ optional($forestal->tipoAreaForestal)->nombre ?? 'No registrado' }}</td>
                    </tr>
                    <tr>
                        <th>Has afectadas</th>
                        <td>{{ number_format($forestal->ha_afectadas, 2) }} ha</td>
                    </tr>
                    <trx>
                        <th>Has pérdidas totales</th>
                        <td>{{ number_format($forestal->ha_perdidas, 2) }} ha</td>
                    </trx>
                    <tr>
                        <th>Valor pérdida</th>
                        <td>$ {{ number_format($forestal->valor_estimado_perdida, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tiempo estimado de recuperación</th>
                        <td>{{ $forestal->tiempo_recuperacion_estimado_anos ?? 'No estimado' }} año(s)</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se registraron daños forestales.</p>
        @endif

    </div>
</div>
