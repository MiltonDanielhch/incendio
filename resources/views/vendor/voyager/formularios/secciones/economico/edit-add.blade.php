@extends('voyager::master')

@section('page_title', 'Actividades económicas – Formulario '.$formulario->codigo_formulario)

@php
    $agricola = $formulario->sectoresAgricolas->first();
    $pecuario = $formulario->sectoresPecuarios->first();
    $forestal = $formulario->areasForestales->first();
@endphp

@section('content')
<div class="page-content container-fluid">
    <form action="{{ route('admin.formularios.economico.update', $formulario) }}" method="POST">
        @csrf @method('PUT')

        {{-- AGRICOLA --}}
        <div class="panel panel-bordered panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-bag"></i> SECTOR AGRÍCOLA</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Tipo de cultivo</label>
                        <select name="agricola[catalogo_id]" class="form-control">
                            <option value="">Ninguno</option>
                            @foreach($cultivos as $c)
                                <option value="{{ $c->id }}"
                                    {{ old('agricola.catalogo_id', optional($agricola)->catalogo_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Has afectadas</label>
                        <input type="number" name="agricola[ha_afectadas]" class="form-control" min="0" step="0.01"
                               value="{{ old('agricola.ha_afectadas', optional($agricola)->ha_afectadas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Has perdidas</label>
                        <input type="number" name="agricola[ha_perdidas]" class="form-control" min="0" step="0.01"
                               value="{{ old('agricola.ha_perdidas', optional($agricola)->ha_perdidas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Producción estimada (kg)</label>
                        <input type="number" name="agricola[produccion_estimada_kg]" class="form-control" min="0" step="0.01"
                               value="{{ old('agricola.produccion_estimada_kg', optional($agricola)->produccion_estimada_kg ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Valor perdida ($)</label>
                        <input type="number" name="agricola[valor_estimado_perdida]" class="form-control" min="0" step="0.01"
                               value="{{ old('agricola.valor_estimado_perdida', optional($agricola)->valor_estimado_perdida ?? 0) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- PECUARIO --}}
        <div class="panel panel-bordered panel-warning" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-bag"></i> SECTOR PECUARIO</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Tipo de especie</label>
                        <select name="pecuario[catalogo_id]" class="form-control">
                            <option value="">Ninguna</option>
                            @foreach($especies as $e)
                                <option value="{{ $e->id }}"
                                    {{ old('pecuario.catalogo_id', optional($pecuario)->catalogo_id) == $e->id ? 'selected' : '' }}>
                                    {{ $e->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Afectados</label>
                        <input type="number" name="pecuario[numero_animales_afectados]" class="form-control" min="0"
                               value="{{ old('pecuario.numero_animales_afectados', optional($pecuario)->numero_animales_afectados ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Fallecidos</label>
                        <input type="number" name="pecuario[numero_animales_fallecidos]" class="form-control" min="0"
                               value="{{ old('pecuario.numero_animales_fallecidos', optional($pecuario)->numero_animales_fallecidos ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Evacuados</label>
                        <input type="number" name="pecuario[numero_animales_evacuados]" class="form-control" min="0"
                               value="{{ old('pecuario.numero_animales_evacuados', optional($pecuario)->numero_animales_evacuados ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Valor perdida ($)</label>
                        <input type="number" name="pecuario[valor_estimado_perdida]" class="form-control" min="0" step="0.01"
                               value="{{ old('pecuario.valor_estimado_perdida', optional($pecuario)->valor_estimado_perdida ?? 0) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- FORESTAL --}}
        <div class="panel panel-bordered panel-default" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-tree"></i> ÁREAS FORESTALES</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Tipo de área</label>
                        <select name="forestal[catalogo_id]" class="form-control">
                            <option value="">Ninguna</option>
                            @foreach($areas as $a)
                                <option value="{{ $a->id }}"
                                    {{ old('forestal.catalogo_id', optional($forestal)->catalogo_id) == $a->id ? 'selected' : '' }}>
                                    {{ $a->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Has perdidas</label>
                        <input type="number" name="forestal[ha_perdidas]" class="form-control" min="0" step="0.01"
                               value="{{ old('forestal.ha_perdidas', optional($forestal)->ha_perdidas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Has afectadas</label>
                        <input type="number" name="forestal[ha_afectadas]" class="form-control" min="0" step="0.01"
                               value="{{ old('forestal.ha_afectadas', optional($forestal)->ha_afectadas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Valor perdida ($)</label>
                        <input type="number" name="forestal[valor_estimado_perdida]" class="form-control" min="0" step="0.01"
                               value="{{ old('forestal.valor_estimado_perdida', optional($forestal)->valor_estimado_perdida ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Tiempo recuperación (años)</label>
                        <input type="number" name="forestal[tiempo_recuperacion_estimado_anos]" class="form-control" min="0"
                               value="{{ old('forestal.tiempo_recuperacion_estimado_anos', optional($forestal)->tiempo_recuperacion_estimado_anos ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTONES FUERA Y AL FINAL --}}
        <div class="panel-footer text-right">
            <a href="{{ route('formularios.ver', $formulario) }}" class="btn btn-default">
                <i class="voyager-angle-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="voyager-check"></i> Actualizar
            </button>
        </div>
    </form>
</div>
@stop
