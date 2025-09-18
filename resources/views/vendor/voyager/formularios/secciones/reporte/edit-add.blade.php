@extends('voyager::master')

@section('page_title', 'Reporte general – Formulario '.$formulario->codigo_formulario)

@php
    $reporte = $formulario->reporteComunitario; // hasOne → null o modelo
@endphp

@section('content')
<div class="page-content container-fluid">
    <form action="{{ $reporte
            ? route('admin.formularios.reporte.update',    [$formulario, $reporte])
            : route('admin.formularios.reporte.store',     $formulario) }}"
          method="POST">
        @csrf
        @if($reporte) @method('PUT') @endif

        <div class="panel panel-bordered panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="voyager-documentation"></i>
                    {{ $reporte ? 'Editar' : 'Agregar' }} reporte general
                </h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <label>Incendios registrados</label>
                        <input type="number" name="incendios_registrados" class="form-control" min="0"
                               value="{{ old('incendios_registrados', optional($reporte)->incendios_registrados ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Incendios activos</label>
                        <input type="number" name="incendios_activos" class="form-control" min="0"
                               value="{{ old('incendios_activos', optional($reporte)->incendios_activos ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Familias afectadas</label>
                        <input type="number" name="num_familias_afectadas" class="form-control" min="0"
                               value="{{ old('num_familias_afectadas', optional($reporte)->num_familias_afectadas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Familias damnificadas</label>
                        <input type="number" name="num_familias_damnificadas" class="form-control" min="0"
                               value="{{ old('num_familias_damnificadas', optional($reporte)->num_familias_damnificadas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Personas evacuadas</label>
                        <input type="number" name="num_personas_evacuadas" class="form-control" min="0"
                               value="{{ old('num_personas_evacuadas', optional($reporte)->num_personas_evacuadas ?? 0) }}">
                    </div>
                    <div class="col-md-6">
                        <label>Necesidades</label>
                        <textarea name="necesidades" class="form-control" rows="3">{{ old('necesidades', optional($reporte)->necesidades) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Ayuda recibida</label>
                        <textarea name="ayuda_recibida" class="form-control" rows="3">{{ old('ayuda_recibida', optional($reporte)->ayuda_recibida) }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label>Vías de acceso afectadas</label>
                        <textarea name="vias_acceso_afectadas" class="form-control" rows="2">{{ old('vias_acceso_afectadas', optional($reporte)->vias_acceso_afectadas) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="panel-footer text-right">
                <a href="{{ route('formularios.ver', $formulario) }}" class="btn btn-default">
                    <i class="voyager-angle-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="voyager-check"></i> {{ $reporte ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </div>
    </form>
</div>
@stop
