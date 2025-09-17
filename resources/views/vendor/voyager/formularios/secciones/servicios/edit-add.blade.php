@extends('voyager::master')

@section('page_title', 'Servicios e infraestructura – Formulario '.$formulario->codigo_formulario)

@php
    $infra    = ($formulario->infraestructuras   ?? collect())->first() ?? null;
    $servicio = ($formulario->serviciosBasicos   ?? collect())->first() ?? null;
    $edu      = ($formulario->educaciones        ?? collect())->first() ?? null;
@endphp

@section('content')
<div class="page-content container-fluid">
    <form action="{{ route('admin.formularios.servicios.update', $formulario) }}"
          method="POST">
        @csrf @method('PUT')

        {{-- INFRAESTRUCTURA --}}
        <div class="panel panel-bordered panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-home"></i> INFRAESTRUCTURA</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Tipo de infraestructura</label>
                        <select name="infra[catalogo_id]" class="form-control">
                            <option value="">Ninguna</option>
                            @foreach($infraTipos as $t)
                                <option value="{{ $t->id }}"
                                    {{ old('infra.catalogo_id', optional($infra)->catalogo_id) == $t->id ? 'selected' : '' }}>
                                    {{ $t->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Cantidad afectada</label>
                        <input type="number" name="infra[cantidad_afectadas]" class="form-control" min="0"
                               value="{{ old('infra.cantidad_afectadas', optional($infra)->cantidad_afectadas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Cantidad destruida</label>
                        <input type="number" name="infra[cantidad_destruidas]" class="form-control" min="0"
                               value="{{ old('infra.cantidad_destruidas', optional($infra)->cantidad_destruidas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Valor pérdida ($)</label>
                        <input type="number" name="infra[valor_estimado_perdida]" class="form-control" min="0" step="0.01"
                               value="{{ old('infra.valor_estimado_perdida', optional($infra)->valor_estimado_perdida ?? 0) }}">
                    </div>
                    <div class="col-md-8">
                        <label>Descripción del daño</label>
                        <textarea name="infra[descripcion_dano]" class="form-control" rows="2">{{ old('infra.descripcion_dano', optional($infra)->descripcion_dano) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- SERVICIOS BÁSICOS --}}
        <div class="panel panel-bordered panel-warning" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-lightbulb"></i> SERVICIOS BÁSICOS</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Tipo de servicio</label>
                        <select name="servicio[catalogo_id]" class="form-control">
                            <option value="">Ninguno</option>
                            @foreach($servTipos as $s)
                                <option value="{{ $s->id }}"
                                    {{ old('servicio.catalogo_id', optional($servicio)->catalogo_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Comunidades afectadas</label>
                        <input type="number" name="servicio[numero_comunidades_afectadas]" class="form-control" min="0"
                               value="{{ old('servicio.numero_comunidades_afectadas', optional($servicio)->numero_comunidades_afectadas ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Días sin servicio</label>
                        <input type="number" name="servicio[dias_sin_servicio]" class="form-control" min="0"
                               value="{{ old('servicio.dias_sin_servicio', optional($servicio)->dias_sin_servicio ?? 0) }}">
                    </div>
                    <div class="col-md-8">
                        <label>Alternativas implementadas</label>
                        <textarea name="servicio[alternativas_implementadas]" class="form-control" rows="2">{{ old('servicio.alternativas_implementadas', optional($servicio)->alternativas_implementadas) }}</textarea>
                    </div>
                    <div class="col-md-8">
                        <label>Descripción del daño</label>
                        <textarea name="servicio[descripcion_dano]" class="form-control" rows="2">{{ old('servicio.descripcion_dano', optional($servicio)->descripcion_dano) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- EDUCACIÓN --}}
        <div class="panel panel-bordered panel-primary" style="margin-top: 15px;">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="voyager-book"></i> EDUCACIÓN</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Institución educativa</label>
                        <select name="edu[catalogo_id]" class="form-control">
                            <option value="">Ninguna</option>
                            @foreach($instituciones as $i)
                                <option value="{{ $i->id }}"
                                    {{ old('edu.catalogo_id', optional($edu)->catalogo_id) == $i->id ? 'selected' : '' }}>
                                    {{ $i->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Modalidad educativa</label>
                        <select name="edu[modalidad_educacion_id]" class="form-control">
                            <option value="">Ninguna</option>
                            @foreach($modalidades as $m)
                                <option value="{{ $m->id }}"
                                    {{ old('edu.modalidad_educacion_id', optional($edu)->modalidad_educacion_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Estudiantes</label>
                        <input type="number" name="edu[num_estudiantes]" class="form-control" min="0"
                               value="{{ old('edu.num_estudiantes', optional($edu)->num_estudiantes ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Estudiantes afectados</label>
                        <input type="number" name="edu[num_estudiantes_afectados]" class="form-control" min="0"
                               value="{{ old('edu.num_estudiantes_afectados', optional($edu)->num_estudiantes_afectados ?? 0) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Días clase perdidos</label>
                        <input type="number" name="edu[dias_clase_perdidos]" class="form-control" min="0"
                               value="{{ old('edu.dias_clase_perdidos', optional($edu)->dias_clase_perdidos ?? 0) }}">
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
