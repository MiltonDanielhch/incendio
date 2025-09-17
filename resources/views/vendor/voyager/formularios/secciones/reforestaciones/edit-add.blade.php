@extends('voyager::master')

@section('page_title', 'Reforestación – Formulario '.$formulario->codigo_formulario)

@php
    $reforest = $formulario->reforestaciones->first(); // null o modelo
@endphp

@section('content')
<div class="page-content container-fluid">
    <form action="{{ $reforest
            ? route('admin.formularios.reforestaciones.update',    [$formulario, $reforest])
            : route('admin.formularios.reforestaciones.store',     $formulario) }}"
          method="POST">
        @csrf
        @if($reforest) @method('PUT') @endif

        <div class="panel panel-bordered panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="voyager-tree"></i>
                    {{ $reforest ? 'Editar' : 'Agregar' }} reforestación
                </h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Especie de plantín <span class="required">*</span></label>
                        <select name="catalogo_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($especies as $e)
                                <option value="{{ $e->id }}"
                                    {{ old('catalogo_id', optional($reforest)->catalogo_id) == $e->id ? 'selected' : '' }}>
                                    {{ $e->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Cantidad de plantines</label>
                        <input type="number" name="cantidad_plantines" class="form-control" min="0"
                               value="{{ old('cantidad_plantines', optional($reforest)->cantidad_plantines ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Área reforestada (ha)</label>
                        <input type="number" name="area_reforestada_ha" class="form-control" min="0" step="0.01"
                               value="{{ old('area_reforestada_ha', optional($reforest)->area_reforestada_ha ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Fecha de reforestación</label>
                        <input type="date" name="fecha_reforestacion" class="form-control"
                               value="{{ old('fecha_reforestacion', optional($reforest)->fecha_reforestacion?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Supervivencia estimada (%)</label>
                        <input type="number" name="supervivencia_estimada_porcentaje" class="form-control" min="0" max="100" step="0.01"
                               value="{{ old('supervivencia_estimada_porcentaje', optional($reforest)->supervivencia_estimada_porcentaje ?? 0) }}">
                    </div>
                </div>
            </div>

            <div class="panel-footer text-right">
                <a href="{{ route('formularios.ver', $formulario) }}" class="btn btn-default">
                    <i class="voyager-angle-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="voyager-check"></i> {{ $reforest ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </div>
    </form>
</div>
@stop
