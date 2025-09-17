<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-home"></i> INFRAESTRUCTURA</h3>
    </div>
    <div class="panel-body">
        @php $infra = $formulario->infraestructuras->first() @endphp
        @if($infra)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Tipo de infraestructura</th>
                        <td>{{ optional($infra->tipoInfraestructura)->nombre ?? 'No registrado' }}</td>
                    </tr>
                    <tr>
                        <th>Cantidad afectada</th>
                        <td>{{ $infra->cantidad_afectadas ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Cantidad destruida</th>
                        <td>{{ $infra->cantidad_destruidas ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Valor pérdida</th>
                        <td>$ {{ number_format($infra->valor_estimado_perdida, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Descripción del daño</th>
                        <td>{{ $infra->descripcion_dano ?? 'No registrada' }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se registraron daños en infraestructura.</p>
        @endif
    </div>
</div>

<div class="panel panel-bordered panel-warning" style="margin-top: 15px;">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-lightbulb"></i> SERVICIOS BÁSICOS</h3>
    </div>
    <div class="panel-body">
        @php $servicio = $formulario->serviciosBasicos->first() @endphp
        @if($servicio)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Tipo de servicio</th>
                        <td>{{ optional($servicio->tipoServicio)->nombre ?? 'No registrado' }}</td>
                    </tr>
                    <tr>
                        <th>Comunidades afectadas</th>
                        <td>{{ $servicio->numero_comunidades_afectadas ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Días sin servicio</th>
                        <td>{{ $servicio->dias_sin_servicio ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Alternativas implementadas</th>
                        <td>{{ $servicio->alternativas_implementadas ?? 'No registradas' }}</td>
                    </tr>
                    <tr>
                        <th>Descripción del daño</th>
                        <td>{{ $servicio->descripcion_dano ?? 'No registrada' }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se registraron afectaciones a servicios básicos.</p>
        @endif
    </div>
</div>

<div class="panel panel-bordered panel-primary" style="margin-top: 15px;">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="voyager-book"></i> EDUCACIÓN</h3>
    </div>
    <div class="panel-body">
        @php $edu = $formulario->educaciones->first() @endphp
        @if($edu)
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="25%">Institución educativa</th>
                        <td>{{ optional($edu->institucion)->nombre ?? 'No registrada' }}</td>
                    </tr>
                    <tr>
                        <th>Modalidad educativa</th>
                        <td>{{ optional($edu->modalidad)->nombre ?? 'No registrada' }}</td>
                    </tr>
                    <tr>
                        <th>Total estudiantes</th>
                        <td>{{ $edu->num_estudiantes ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Estudiantes afectados</th>
                        <td>{{ $edu->num_estudiantes_afectados ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Días de clase perdidos</th>
                        <td>{{ $edu->dias_clase_perdidos ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-muted">No se registraron afectaciones al sector educación.</p>
        @endif
    </div>
</div>
