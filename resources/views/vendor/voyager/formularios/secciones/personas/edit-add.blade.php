{{-- @extends('voyager::master')

@section('page_title', 'Personas afectadas – Formulario '.$formulario->codigo_formulario)

@php
    $registro     = $formulario->afectadosIncendios->first(); // null si no existe
    $salud        = $formulario->salud->first();              // null si no existe
@endphp

@section('content')
<div class="page-content container-fluid">
    <form action="{{ $registro
            ? route('admin.formularios.personas.update',    [$formulario, $registro])
            : route('admin.formularios.personas.store',     $formulario) }}"
          method="POST">
        @csrf
        @if($registro) @method('PUT') @endif


        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="voyager-people"></i>
                    {{ $registro ? 'Editar' : 'Agregar' }} personas afectadas
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Grupo etario <span class="required">*</span></label>
                        <select name="grupo_etario_id" class="form-control" required>
                            @foreach($grupos as $g)
                                <option value="{{ $g->id }}"
                                    {{ old('grupo_etario_id', optional($registro)->grupo_etario_id) == $g->id ? 'selected' : '' }}>
                                    {{ $g->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Afectados</label>
                        <input type="number" name="cantidad_afectados" class="form-control" min="0"
                               value="{{ old('cantidad_afectados', optional($registro)->cantidad_afectados ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Fallecidos</label>
                        <input type="number" name="cantidad_fallecidos" class="form-control" min="0"
                               value="{{ old('cantidad_fallecidos', optional($registro)->cantidad_fallecidos ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Lesionados</label>
                        <input type="number" name="cantidad_lesionados" class="form-control" min="0"
                               value="{{ old('cantidad_lesionados', optional($registro)->cantidad_lesionados ?? 0) }}">
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-bordered panel-info" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-heart"></i> SALUD</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Enfermedad o condición</label>
                        <select name="salud[catalogo_id]" class="form-control">
                            <option value="">Ninguna</option>
                            @foreach($enfermedades as $e)
                                <option value="{{ $e->id }}"
                                    {{ old('salud.catalogo_id', optional($salud)->catalogo_id) == $e->id ? 'selected' : '' }}>
                                    {{ $e->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Cantidad enfermos</label>
                        <input type="number" name="salud[cantidad_enfermos]" class="form-control" min="0"
                               value="{{ old('salud.cantidad_enfermos', optional($salud)->cantidad_enfermos ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Gravedad promedio</label>
                        <input type="number" name="salud[gravedad_promedio]" class="form-control" min="1" max="5"
                               value="{{ old('salud.gravedad_promedio', optional($salud)->gravedad_promedio ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label>Tratamiento requerido</label>
                        <textarea name="salud[tratamiento_requerido]" class="form-control" rows="2">{{ old('salud.tratamiento_requerido', optional($salud)->tratamiento_requerido) }}</textarea>
                    </div>
                </div>
            </div>
        </div>


        <div class="panel-footer text-right">
            <a href="{{ route('formularios.ver', $formulario) }}" class="btn btn-default">
                <i class="voyager-angle-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="voyager-check"></i> {{ $registro ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
@stop --}}

@extends('voyager::master')

@section('page_title', 'Personas afectadas – Formulario '.$formulario->codigo_formulario)

@php
    $afectados = $formulario->afectadosIncendios->keyBy('grupo_etario_id');
    // ✅ ahora agrupamos por (enfermedad, grupo)
    $salud     = $formulario->salud
                 ->groupBy(['catalogo_id', 'grupo_etario_id']);
@endphp

@section('content')
<div class="page-content container-fluid">
    <form id="formPersonasSalud" method="POST"
          action="{{ route('admin.formularios.personas.matriz.rapido', $formulario) }}">
        @csrf

        {{-- 1. PERSONAS AFECTADAS --}}
        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-people"></i> PERSONAS AFECTADAS POR GRUPO ETARIO</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="matrizPersonas">
                        <thead>
                            <tr>
                                <th>Grupo etario</th>
                                <th>Afectados</th>
                                <th>Lesionados</th>
                                <th>Fallecidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupos as $grupo)
                                @php $af = $afectados->get($grupo->id); @endphp
                                <tr data-grupo-id="{{ $grupo->id }}">
                                    <td>{{ $grupo->nombre }}</td>
                                    <td>
                                        <input type="number" min="0" name="filas[{{ $grupo->id }}][afectados]"
                                               class="form-control input-sm afectados"
                                               value="{{ $af?->cantidad_afectados ?? 0 }}">
                                    </td>
                                    <td>
                                        <input type="number" min="0" name="filas[{{ $grupo->id }}][lesionados]"
                                               class="form-control input-sm lesionados"
                                               value="{{ $af?->cantidad_lesionados ?? 0 }}">
                                    </td>
                                    <td>
                                        <input type="number" min="0" name="filas[{{ $grupo->id }}][fallecidos]"
                                               class="form-control input-sm fallecidos"
                                               value="{{ $af?->cantidad_fallecidos ?? 0 }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="active">
                                <th>Totales</th>
                                <th id="totalAfectados">0</th>
                                <th id="totalLesionados">0</th>
                                <th id="totalFallecidos">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- SALUD COMO FILA + MINI-FORM POR CELDA --}}
        <div class="panel panel-bordered panel-info" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-heart"></i> SALUD POR ENFERMEDAD</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive table-striped">
                    <table class="table" role="table" aria-labelledby="saludTable">
                        <thead>
                            <tr>
                                <th>Enfermedad</th>
                                @foreach($grupos as $grupo)
                                    <th class="text-center">{{ $grupo->nombre }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enfermedades as $enf)
                                <tr>
                                    <td>
                                        {{ $enf->nombre }}
                                        <input type="hidden" name="enfermedad_id[]" value="{{ $enf->id }}">
                                    </td>
                                    @foreach($grupos as $grupo)
                                        @php
                                            // Buscamos la celda exacta (enfermedad, grupo)
                                            $reg  = $salud[$enf->id][$grupo->id] ?? collect();
                                            $reg  = $reg->first();              // 0 ó 1 modelo
                                            $cant = $reg->cantidad_enfermos     ?? 0;
                                            $grav = $reg->gravedad_promedio     ?? '';
                                            $trat = $reg->tratamiento_requerido ?? '';
                                        @endphp
                                        <td class="p-2">
                                            <label class="small mb-0">Cant.</label>
                                            <input type="number" min="0"
                                                name="salud[{{ $enf->id }}][{{ $grupo->id }}][cantidad_enfermos]"
                                                class="form-control form-control-sm mb-1"
                                                value="{{ $cant }}">

                                            <label class="small mb-0">Grav.</label>
                                            <input type="number" min="1" max="5"
                                                name="salud[{{ $enf->id }}][{{ $grupo->id }}][gravedad_promedio]"
                                                class="form-control form-control-sm mb-1"
                                                value="{{ $grav }}">

                                            <label class="small mb-0">Trat.</label>
                                            <textarea name="salud[{{ $enf->id }}][{{ $grupo->id }}][tratamiento_requerido]"
                                                    class="form-control form-control-sm"
                                                    rows="2"
                                                    placeholder="Ej: Gotas antihistamínicas">{{ $trat }}</textarea>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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

@push('javascript')
<script>
$(function () {
    // ---------- totales personas ----------
    function calcularPersonas() {
        let a = 0, l = 0, f = 0;
        $('#matrizPersonas tbody tr').each(function () {
            a += parseInt($(this).find('.afectados').val()) || 0;
            l += parseInt($(this).find('.lesionados').val()) || 0;
            f += parseInt($(this).find('.fallecidos').val()) || 0;
        });
        $('#totalAfectados').text(a);
        $('#totalLesionados').text(l);
        $('#totalFallecidos').text(f);
    }
    calcularPersonas();
    $('#matrizPersonas').on('input', 'input', calcularPersonas);

    // ---------- totales salud ----------
    function calcularSalud() {
        let e = 0;
        $('#matrizSalud tbody tr').each(function () {
            e += parseInt($(this).find('.enfermos').val()) || 0;
        });
        $('#totalEnfermos').text(e);
    }
    calcularSalud();
    $('#matrizSalud').on('input', 'input', calcularSalud);
});
</script>
@endpush
