@extends('voyager::master')

@section('page_title', 'Asistencia – Formulario '.$formulario->codigo_formulario)

@php
    $asist = $formulario->asistencias->first(); // null o modelo
@endphp

@section('content')
<div class="page-content container-fluid">
    <form action="{{ $asist
            ? route('admin.formularios.asistencias.update',    [$formulario, $asist])
            : route('admin.formularios.asistencias.store',     $formulario) }}"
          method="POST">
        @csrf
        @if($asist) @method('PUT') @endif

        <div class="panel panel-bordered panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="voyager-basket"></i>
                    {{ $asist ? 'Editar' : 'Agregar' }} asistencia
                </h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Tipo de asistencia <span class="required">*</span></label>
                        <select name="tipo_asistencia_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($tipos as $t)
                                <option value="{{ $t->id }}"
                                    {{ old('tipo_asistencia_id', optional($asist)->tipo_asistencia_id) == $t->id ? 'selected' : '' }}>
                                    {{ $t->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Fecha de asistencia</label>
                        <input type="date" name="fecha_asistencia" class="form-control"
                               value="{{ old('fecha_asistencia', optional($asist)->fecha_asistencia?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label>Organización proveedora</label>
                        <input type="text" name="organizacion_proveedora" class="form-control"
                               value="{{ old('organizacion_proveedora', optional($asist)->organizacion_proveedora) }}">
                    </div>
                    <div class="col-md-6">
                        <label>Actividades</label>
                        <textarea name="actividades" class="form-control" rows="2">{{ old('actividades', optional($asist)->actividades) }}</textarea>
                    </div>
                    <div class="col-md-2">
                        <label>Cantidad beneficiarios</label>
                        <input type="number" name="cantidad_beneficiarios" class="form-control" min="0"
                               value="{{ old('cantidad_beneficiarios', optional($asist)->cantidad_beneficiarios ?? 0) }}">
                    </div>
                    <div class="col-md-4">
                        <label>Valor de la asistencia ($)</label>
                        <input type="number" name="valor_asistencia" class="form-control" min="0" step="0.01"
                               value="{{ old('valor_asistencia', optional($asist)->valor_asistencia ?? 0) }}">
                    </div>
                </div>
            </div>

            <div class="panel-footer text-right">
                <a href="{{ route('formularios.ver', $formulario) }}" class="btn btn-default">
                    <i class="voyager-angle-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="voyager-check"></i> {{ $asist ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </div>
    </form>
</div>
@stop
