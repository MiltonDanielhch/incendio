@extends('voyager::master')

@section('page_title', 'Servicios e infraestructura – Formulario '.$formulario->codigo_formulario)

@section('content')
<div class="page-content container-fluid">
    <form id="formServiciosMatriz" method="POST"
          action="{{ route('admin.formularios.servicios.matriz.rapido', $formulario) }}">
        @csrf

        {{-- MATRIZ INFRAESTRUCTURA POR TIPO --}}
        <div class="panel panel-bordered panel-danger" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-home"></i> INFRAESTRUCTURA POR TIPO</h3>
            </div>
            <div class="panel-body p-2">
                <table class="table table-bordered mb-0" id="matrizInfra">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo de infraestructura</th>
                            <th>Cantidad afectada</th>
                            <th>Cantidad destruida</th>
                            <th>Valor pérdida ($)</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $infraTipos = $infraTipos ?? collect();
                            $infra = $formulario->infraestructuras->keyBy('catalogo_id');
                        @endphp
                        @foreach($infraTipos as $tipo)
                            @php $reg = $infra->get($tipo->id); @endphp
                            <tr data-infra-id="{{ $tipo->id }}">
                                <td>
                                    {{ $tipo->nombre }}
                                    <input type="hidden" name="filas[{{ $tipo->id }}][catalogo_id]" value="{{ $tipo->id }}">
                                </td>
                                <td><input type="number" min="0" name="filas[{{ $tipo->id }}][cantidad_afectadas]"
                                           class="form-control input-sm" value="{{ optional($reg)->cantidad_afectadas ?? 0 }}"></td>
                                <td><input type="number" min="0" name="filas[{{ $tipo->id }}][cantidad_destruidas]"
                                           class="form-control input-sm" value="{{ optional($reg)->cantidad_destruidas ?? 0 }}"></td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $tipo->id }}][valor_estimado_perdida]"
                                           class="form-control input-sm" value="{{ optional($reg)->valor_estimado_perdida ?? 0 }}"></td>
                                <td class="text-center total-fila"><strong>0</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="active">
                            <th>Total general</th>
                            <th class="text-center" id="totalAfectadasInfra">0</th>
                            <th class="text-center" id="totalDestruidasInfra">0</th>
                            <th class="text-center" id="totalValorInfra">0</th>
                            <th class="text-center" id="totalGeneralInfra">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- MATRIZ SERVICIOS BÁSICOS POR TIPO --}}
        <div class="panel panel-bordered panel-warning" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-lightbulb"></i> SERVICIOS BÁSICOS POR TIPO</h3>
            </div>
            <div class="panel-body p-2">
                <table class="table table-bordered mb-0" id="matrizServicios">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo de servicio</th>
                            <th>Comunidades afectadas</th>
                            <th>Días sin servicio</th>
                            <th>Valor pérdida ($)</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $servTipos = $servTipos ?? collect();
                            $servicios = $formulario->serviciosBasicos->keyBy('catalogo_id');
                        @endphp
                        @foreach($servTipos as $tipo)
                            @php $reg = $servicios->get($tipo->id); @endphp
                            <tr data-servicio-id="{{ $tipo->id }}">
                                <td>
                                    {{ $tipo->nombre }}
                                    <input type="hidden" name="filas[{{ $tipo->id }}][catalogo_id]" value="{{ $tipo->id }}">
                                </td>
                                <td><input type="number" min="0" name="filas[{{ $tipo->id }}][numero_comunidades_afectadas]"
                                           class="form-control input-sm" value="{{ optional($reg)->numero_comunidades_afectadas ?? 0 }}"></td>
                                <td><input type="number" min="0" name="filas[{{ $tipo->id }}][dias_sin_servicio]"
                                           class="form-control input-sm" value="{{ optional($reg)->dias_sin_servicio ?? 0 }}"></td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $tipo->id }}][valor_estimado_perdida]"
                                           class="form-control input-sm" value="{{ optional($reg)->valor_estimado_perdida ?? 0 }}"></td>
                                <td class="text-center total-fila"><strong>0</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="active">
                            <th>Total general</th>
                            <th class="text-center" id="totalComunidadesServ">0</th>
                            <th class="text-center" id="totalDiasServ">0</th>
                            <th class="text-center" id="totalValorServ">0</th>
                            <th class="text-center" id="totalGeneralServ">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- EDUCACIÓN: INSTITUCIÓN → MODALIDAD --}}
        <div class="panel panel-bordered panel-primary" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-book"></i> EDUCACIÓN POR INSTITUCIÓN Y MODALIDAD</h3>
            </div>
            <div class="panel-body p-2">
                <table class="table table-bordered mb-0" id="matrizEduInst">
                    <thead>
                        <tr>
                            <th>Institución educativa</th>
                            <th class="text-center">Presencial</th>
                            <th class="text-center">Semi-presencial</th>
                            <th class="text-center">Virtual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // indexar por (institución, modalidad)
                            $edu = $formulario->educaciones
                                ->groupBy(['catalogo_id','modalidad_educacion_id']);
                        @endphp
                        @foreach($instituciones as $inst)
                            <tr data-inst-id="{{ $inst->id }}">
                                <td>
                                    {{ $inst->nombre }}
                                    <input type="hidden"
                                        name="edu[{{ $inst->id }}][catalogo_id]"
                                        value="{{ $inst->id }}">
                                </td>
                                @foreach($modalidades as $mod)
                                    @php
                                        $reg = $edu[$inst->id][$mod->id] ?? collect();
                                        $reg = $reg->first(); // 0 ó 1
                                        $est = $reg->num_estudiantes          ?? 0;
                                        $afec= $reg->num_estudiantes_afectados?? 0;
                                        $dias= $reg->dias_clase_perdidos      ?? 0;
                                    @endphp
                                    <td class="p-2">
                                        {{-- ✅ CORRECTO: solo estos dos --}}
                                        <input type="hidden" name="edu[{{ $inst->id }}][{{ $mod->id }}][modalidad_educacion_id]" value="{{ $mod->id }}">
                                        <input type="hidden" name="edu[{{ $inst->id }}][{{ $mod->id }}][catalogo_id]" value="{{ $inst->id }}">

                                        <label class="small mb-0">Est.</label>
                                        <input type="number" min="0"
                                            name="edu[{{ $inst->id }}][{{ $mod->id }}][num_estudiantes]"
                                            class="form-control form-control-sm mb-1"
                                            value="{{ $est }}">
                                        <label class="small mb-0">Afect.</label>
                                        <input type="number" min="0"
                                            name="edu[{{ $inst->id }}][{{ $mod->id }}][num_estudiantes_afectados]"
                                            class="form-control form-control-sm mb-1"
                                            value="{{ $afec }}">
                                        <label class="small mb-0">Días</label>
                                        <input type="number" min="0"
                                            name="edu[{{ $inst->id }}][{{ $mod->id }}][dias_clase_perdidos]"
                                            class="form-control form-control-sm"
                                            value="{{ $dias }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        {{-- Total general de servicios --}}
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <h4><strong>Total general de servicios e infraestructura:</strong> $<span id="granTotalServicios">0</span></h4>
            </div>
        </div>

        {{-- BOTONES --}}
        <div class="panel-footer text-right">
            <a href="{{ route('formularios.ver', $formulario) }}" class="btn btn-default">
                <i class="voyager-angle-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="voyager-check"></i> Guardar cambios
            </button>
        </div>
    </form>
</div>
@stop

{{-- JS para sumar por modalidad --}}
@push('javascript')
<script>
function calcularEduInst(){
    let pres=0, semi=0, vir=0;
    $('#matrizEduInst tbody tr').each(function(){
        let $cols = $(this).find('td:gt(0)'); // saltar 1ª columna
        pres += parseInt($cols.eq(0).find('input[name$="[num_estudiantes]"]').val()) || 0;
        semi += parseInt($cols.eq(1).find('input[name$="[num_estudiantes]"]').val()) || 0;
        vir  += parseInt($cols.eq(2).find('input[name$="[num_estudiantes]"]').val()) || 0;
    });
    console.log('Presencial:', pres, 'Semi:', semi, 'Virtual:', vir);
}
calcularEduInst();
$('#matrizEduInst').on('input','input',calcularEduInst);
</script>
@endpush


{{-- JS para sumar por modalidad --}}
@push('javascript')
<script>
function calcularEduInst(){
    let pres=0, semi=0, vir=0;
    $('#matrizEduInst tbody tr').each(function(){
        let $cols = $(this).find('td:gt(0)'); // saltar 1ª columna
        pres += parseInt($cols.eq(0).find('input[name$="[num_estudiantes]"]').val()) || 0;
        semi += parseInt($cols.eq(1).find('input[name$="[num_estudiantes]"]').val()) || 0;
        vir  += parseInt($cols.eq(2).find('input[name$="[num_estudiantes]"]').val()) || 0;
    });
    // puedes mostrar los totales donde quieras
    console.log('Presencial:', pres, 'Semi:', semi, 'Virtual:', vir);
}
calcularEduInst();
$('#matrizEduInst').on('input','input',calcularEduInst);
</script>
@endpush

@push('javascript')
<script>
$(function () {
    function calcularServicios() {
        // Infraestructura
        let infraAfect = 0, infraDestr = 0, infraVal = 0;
        $('#matrizInfra tbody tr').each(function () {
            let afect = parseFloat($(this).find('input[name$="[cantidad_afectadas]"]').val()) || 0;
            let destr = parseFloat($(this).find('input[name$="[cantidad_destruidas]"]').val()) || 0;
            let valor = parseFloat($(this).find('input[name$="[valor_estimado_perdida]"]').val()) || 0;
            let fila = afect + destr + valor;
            $(this).find('.total-fila').text(new Intl.NumberFormat('es-AR').format(Math.round(fila)));
            infraAfect += afect;
            infraDestr += destr;
            infraVal   += valor;
        });
        $('#totalAfectadasInfra').text(new Intl.NumberFormat('es-AR').format(infraAfect));
        $('#totalDestruidasInfra').text(new Intl.NumberFormat('es-AR').format(infraDestr));
        $('#totalValorInfra').text(new Intl.NumberFormat('es-AR').format(infraVal));
        $('#totalGeneralInfra').text(new Intl.NumberFormat('es-AR').format(Math.round(infraAfect + infraDestr + infraVal)));

        // Servicios básicos
        let servCom = 0, servDias = 0, servVal = 0;
        $('#matrizServicios tbody tr').each(function () {
            let com   = parseFloat($(this).find('input[name$="[numero_comunidades_afectadas]"]').val()) || 0;
            let dias  = parseFloat($(this).find('input[name$="[dias_sin_servicio]"]').val()) || 0;
            let valor = parseFloat($(this).find('input[name$="[valor_estimado_perdida]"]').val()) || 0;
            let fila = com + dias + valor;
            $(this).find('.total-fila').text(new Intl.NumberFormat('es-AR').format(Math.round(fila)));
            servCom  += com;
            servDias += dias;
            servVal  += valor;
        });
        $('#totalComunidadesServ').text(new Intl.NumberFormat('es-AR').format(servCom));
        $('#totalDiasServ').text(new Intl.NumberFormat('es-AR').format(servDias));
        $('#totalValorServ').text(new Intl.NumberFormat('es-AR').format(servVal));
        $('#totalGeneralServ').text(new Intl.NumberFormat('es-AR').format(Math.round(servCom + servDias + servVal)));

        // Educación
        let eduEst = 0, eduAfec = 0, eduDias = 0;
        $('#matrizEducacion tbody tr').each(function () {
            let est   = parseFloat($(this).find('input[name$="[num_estudiantes]"]').val()) || 0;
            let afec  = parseFloat($(this).find('input[name$="[num_estudiantes_afectados]"]').val()) || 0;
            let dias  = parseFloat($(this).find('input[name$="[dias_clase_perdidos]"]').val()) || 0;
            let fila = est + afec + dias;
            $(this).find('.total-fila').text(new Intl.NumberFormat('es-AR').format(Math.round(fila)));
            eduEst  += est;
            eduAfec += afec;
            eduDias += dias;
        });
        $('#totalEstudiantesEdu').text(new Intl.NumberFormat('es-AR').format(eduEst));
        $('#totalAfectadosEdu').text(new Intl.NumberFormat('es-AR').format(eduAfec));
        $('#totalDiasEdu').text(new Intl.NumberFormat('es-AR').format(eduDias));
        $('#totalGeneralEdu').text(new Intl.NumberFormat('es-AR').format(Math.round(eduEst + eduAfec + eduDias)));

        // ---------- GRAN TOTAL SERVICIOS ----------
        let granTotal = infraVal + servVal + 0; // educación no tiene campo monetario
        $('#granTotalServicios').text(new Intl.NumberFormat('es-AR').format(Math.round(granTotal)));
    }

    calcularServicios();
    $(document).on('input', '#matrizInfra input, #matrizServicios input, #matrizEducacion input', calcularServicios);
});
</script>
@endpush
