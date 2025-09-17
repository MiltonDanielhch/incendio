<h4>📋 Información del formulario</h4>
<table class="table table-bordered">
    <tr><th width="200">Código</th><td>{{ $formulario->codigo_formulario }}</td></tr>
    <tr><th>Estado</th><td><span class="label label-{{ $formulario->estado == 'validado' ? 'success' : ($formulario->estado == 'rechazado' ? 'danger' : 'warning') }}">{{ ucfirst($formulario->estado) }}</span></td></tr>
    <tr><th>Fecha de llenado</th><td>{{ $formulario->fecha_llenado->format('d/m/Y') }}</td></tr>
    <tr><th>Encuestador</th><td>{{ $formulario->nombre_encuestador }} – {{ $formulario->contacto_encuestador }}</td></tr>
    <tr><th>Comunidad</th>
        <td>{{ $formulario->comunidad->nombre }}
            ({{ $formulario->comunidad->municipio->nombre }},
            {{ $formulario->comunidad->municipio->provincia->nombre }})
        </td>
    </tr>
</table>
<hr>
