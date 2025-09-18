@extends('voyager::master')

@section('page_title', 'Actividades económicas – Formulario '.$formulario->codigo_formulario)

@php
    $agricola = $formulario->sectoresAgricolas->first();
    $pecuario = $formulario->sectoresPecuarios->first();
    $forestal = $formulario->areasForestales->first();
@endphp

@section('content')
<div class="page-content container-fluid">
    <form action="{{ route('admin.formularios.economico.matriz.rapido', $formulario) }}" method="POST">
        @csrf
        {{-- @method('PUT') --}}

        {{-- MATRIZ AGRÍCOLA POR CULTIVO (fila = cultivo) --}}
        <div class="panel panel-bordered panel-success" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-dollar"></i> SECTOR AGRÍCOLA POR CULTIVO</h3>
            </div>
            <div class="panel-body p-2">
                <table class="table table-bordered mb-0" id="matrizAgricola">
                    <thead class="table-light">
                        <tr>
                            <th>Cultivo</th>
                            <th>Ha afectadas</th>
                            <th>Ha pérdidas</th>
                            <th>Producción (kg)</th>
                            <th>Valor pérdida ($)</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cultivos = $cultivos ?? collect(); // asegurá que venga del controlador
                            $agricolas = $formulario->sectoresAgricolas->keyBy('catalogo_id');
                        @endphp
                        @foreach($cultivos as $cultivo)
                            @php
                                $reg = $agricolas->get($cultivo->id);
                            @endphp
                            <tr data-cultivo-id="{{ $cultivo->id }}">
                                <td>
                                    {{ $cultivo->nombre }}
                                    <input type="hidden" name="filas[{{ $cultivo->id }}][catalogo_id]" value="{{ $cultivo->id }}">
                                </td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $cultivo->id }}][ha_afectadas]"
                                        class="form-control input-sm ha-afectadas" value="{{ optional($reg)->ha_afectadas ?? 0 }}"></td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $cultivo->id }}][ha_perdidas]"
                                        class="form-control input-sm ha-perdidas" value="{{ optional($reg)->ha_perdidas ?? 0 }}"></td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $cultivo->id }}][produccion_estimada_kg]"
                                        class="form-control input-sm cantidad" value="{{ optional($reg)->produccion_estimada_kg ?? 0 }}"></td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $cultivo->id }}][valor_estimado_perdida]"
                                        class="form-control input-sm valor" value="{{ optional($reg)->valor_estimado_perdida ?? 0 }}"></td>
                                <td class="text-center total-fila"><strong>0</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="active">
                            <th>Total general</th>
                            <th class="text-center" id="totalHaAfectadas">0</th>
                            <th class="text-center" id="totalHaPerdidas">0</th>
                            <th class="text-center" id="totalKg">0</th>
                            <th class="text-center" id="totalValor">0</th>
                            <th class="text-center" id="totalGeneral">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- PECUARIO como fila de la matriz (debajo de Agrícola) --}}
        <div class="panel panel-bordered panel-warning" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-bag"></i> SECTOR PECUARIO POR ESPECIE</h3>
            </div>
            <div class="panel-body p-2">
                <table class="table table-bordered mb-0" id="matrizPecuario">
                    <thead class="table-light">
                        <tr>
                            <th>Especie</th>
                            <th>Afectados</th>
                            <th>Fallecidos</th>
                            <th>Evacuados</th>
                            <th>Valor pérdida ($)</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $especies = $especies ?? collect(); // asegurá que venga del controlador
                            $pecuarios = $formulario->sectoresPecuarios->keyBy('catalogo_id');
                        @endphp
                        @foreach($especies as $especie)
                            @php
                                $reg = $pecuarios->get($especie->id);
                            @endphp
                            <tr data-especie-id="{{ $especie->id }}">
                                <td>
                                    {{ $especie->nombre }}
                                    <input type="hidden" name="filas[{{ $especie->id }}][catalogo_id]" value="{{ $especie->id }}">
                                </td>
                                <td><input type="number" min="0" name="filas[{{ $especie->id }}][numero_animales_afectados]"
                                        class="form-control input-sm" value="{{ optional($reg)->numero_animales_afectados ?? 0 }}"></td>
                                <td><input type="number" min="0" name="filas[{{ $especie->id }}][numero_animales_fallecidos]"
                                        class="form-control input-sm" value="{{ optional($reg)->numero_animales_fallecidos ?? 0 }}"></td>
                                <td><input type="number" min="0" name="filas[{{ $especie->id }}][numero_animales_evacuados]"
                                        class="form-control input-sm" value="{{ optional($reg)->numero_animales_evacuados ?? 0 }}"></td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $especie->id }}][valor_estimado_perdida]"
                                        class="form-control input-sm" value="{{ optional($reg)->valor_estimado_perdida ?? 0 }}"></td>
                                <td class="text-center total-fila"><strong>0</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="active">
                            <th>Total general</th>
                            <th class="text-center" id="totalAfectados">0</th>
                            <th class="text-center" id="totalFallecidos">0</th>
                            <th class="text-center" id="totalEvacuados">0</th>
                            <th class="text-center" id="totalValor">0</th>
                            <th class="text-center" id="totalGeneral">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- FORESTAL como fila de la matriz (debajo de Pecuario) --}}
        <div class="panel panel-bordered panel-default" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-tree"></i> ÁREAS FORESTALES POR TIPO</h3>
            </div>
            <div class="panel-body p-2">
                <table class="table table-bordered mb-0" id="matrizForestal">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo de área</th>
                            <th>Ha afectadas</th>
                            <th>Ha pérdidas</th>
                            <th>Tiempo recuperación (años)</th>
                            <th>Valor pérdida ($)</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $areas = $areas ?? collect(); // asegurá que venga del controlador
                            $forestales = $formulario->areasForestales->keyBy('catalogo_id');
                        @endphp
                        @foreach($areas as $area)
                            @php
                                $reg = $forestales->get($area->id);
                            @endphp
                            <tr data-area-id="{{ $area->id }}">
                                <td>
                                    {{ $area->nombre }}
                                    <input type="hidden" name="filas[{{ $area->id }}][catalogo_id]" value="{{ $area->id }}">
                                </td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $area->id }}][ha_afectadas]"
                                        class="form-control input-sm" value="{{ optional($reg)->ha_afectadas ?? 0 }}"></td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $area->id }}][ha_perdidas]"
                                        class="form-control input-sm" value="{{ optional($reg)->ha_perdidas ?? 0 }}"></td>
                                <td><input type="number" min="0" name="filas[{{ $area->id }}][tiempo_recuperacion_estimado_anos]"
                                        class="form-control input-sm" value="{{ optional($reg)->tiempo_recuperacion_estimado_anos ?? '' }}"></td>
                                <td><input type="number" min="0" step="0.01" name="filas[{{ $area->id }}][valor_estimado_perdida]"
                                        class="form-control input-sm" value="{{ optional($reg)->valor_estimado_perdida ?? 0 }}"></td>
                                <td class="text-center total-fila"><strong>0</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="active">
                            <th>Total general</th>
                            <th class="text-center" id="totalHaAfectadasForestal">0</th>
                            <th class="text-center" id="totalHaPerdidasForestal">0</th>
                            <th class="text-center" id="totalAnosForestal">0</th>
                            <th class="text-center" id="totalValorForestal">0</th>
                            <th class="text-center" id="totalGeneralForestal">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Total general económico --}}
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <h4><strong>Total general económico:</strong> $<span id="granTotalEconomico">0</span></h4>
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
@stop

@push('javascript')
<script>
$(function () {
    // ---------- CALCULA TODAS LAS MATRICES ----------
    function calcularTodasLasMatrices() {
        // Agrícola
        let agrHaAf = 0, agrHaPer = 0, agrKg = 0, agrVal = 0;
        $('#matrizAgricola tbody tr').each(function () {
            agrHaAf  += parseFloat($(this).find('.ha-afectadas').val()) || 0;
            agrHaPer += parseFloat($(this).find('.ha-perdidas').val())   || 0;
            agrKg    += parseFloat($(this).find('.cantidad').val())      || 0;
            agrVal   += parseFloat($(this).find('.valor').val())         || 0;
            let filaAgr = agrHaAf + agrHaPer + agrKg + agrVal;
            $(this).find('.total-fila').text(new Intl.NumberFormat('es-AR').format(Math.round(filaAgr)));
        });
        $('#totalHaAfectadas').text(new Intl.NumberFormat('es-AR').format(agrHaAf));
        $('#totalHaPerdidas').text(new Intl.NumberFormat('es-AR').format(agrHaPer));
        $('#totalKg').text(new Intl.NumberFormat('es-AR').format(agrKg));
        $('#totalValor').text(new Intl.NumberFormat('es-AR').format(agrVal));

        // Pecuario
        let pecAfect = 0, pecFall = 0, pecEvac = 0, pecVal = 0;
        $('#matrizPecuario tbody tr').each(function () {
            pecAfect += parseFloat($(this).find('input[name$="[numero_animales_afectados]"]').val()) || 0;
            pecFall  += parseFloat($(this).find('input[name$="[numero_animales_fallecidos]"]').val()) || 0;
            pecEvac  += parseFloat($(this).find('input[name$="[numero_animales_evacuados]"]').val()) || 0;
            pecVal   += parseFloat($(this).find('input[name$="[valor_estimado_perdida]"]').val()) || 0;
            let filaPec = pecAfect + pecFall + pecEvac + pecVal;
            $(this).find('.total-fila').text(new Intl.NumberFormat('es-AR').format(Math.round(filaPec)));
        });
        $('#totalAfectados').text(new Intl.NumberFormat('es-AR').format(pecAfect));
        $('#totalFallecidos').text(new Intl.NumberFormat('es-AR').format(pecFall));
        $('#totalEvacuados').text(new Intl.NumberFormat('es-AR').format(pecEvac));
        $('#totalValorPecuario').text(new Intl.NumberFormat('es-AR').format(pecVal));

        // Forestal
        let forHaAf = 0, forHaPer = 0, forAnos = 0, forVal = 0;
        $('#matrizForestal tbody tr').each(function () {
            forHaAf  += parseFloat($(this).find('input[name$="[ha_afectadas]"]').val()) || 0;
            forHaPer += parseFloat($(this).find('input[name$="[ha_perdidas]"]').val()) || 0;
            forAnos  += parseFloat($(this).find('input[name$="[tiempo_recuperacion_estimado_anos]"]').val()) || 0;
            forVal   += parseFloat($(this).find('input[name$="[valor_estimado_perdida]"]').val()) || 0;
            let filaFor = forHaAf + forHaPer + forAnos + forVal;
            $(this).find('.total-fila').text(new Intl.NumberFormat('es-AR').format(Math.round(filaFor)));
        });
        $('#totalHaAfectadasForestal').text(new Intl.NumberFormat('es-AR').format(forHaAf));
        $('#totalHaPerdidasForestal').text(new Intl.NumberFormat('es-AR').format(forHaPer));
        $('#totalAnosForestal').text(new Intl.NumberFormat('es-AR').format(forAnos));
        $('#totalValorForestal').text(new Intl.NumberFormat('es-AR').format(forVal));

        // ---------- TOTAL GENERAL ----------
        let granTotal = agrHaAf + agrHaPer + agrKg + agrVal +
                        pecAfect + pecFall + pecEvac + pecVal +
                        forHaAf + forHaPer + forAnos + forVal;

        $('#granTotalEconomico').text(new Intl.NumberFormat('es-AR').format(Math.round(granTotal)));
    }

    // ---------- Ejecutar al cargar y en cada cambio ----------
    calcularTodasLasMatrices();
    $(document).on('input', '#matrizAgricola input, #matrizPecuario input, #matrizForestal input', calcularTodasLasMatrices);
});
</script>
@endpush
