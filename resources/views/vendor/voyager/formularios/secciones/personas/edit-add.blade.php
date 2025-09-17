@extends('voyager::master')

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

        {{-- PERSONAS --}}
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

        {{-- SALUD --}}
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

        {{-- BOTONES FUERA Y AL FINAL DEL FORMULARIO --}}
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
@stop
