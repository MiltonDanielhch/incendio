@extends('voyager::master')

@section('page_title', 'Ver formulario de incendio')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-fire"></i> Formulario N° {{ $formulario->codigo_formulario }}
        </h1>
    </div>
@stop

@section('content')
<div class="page-content container-fluid">

    {{-- 0. Barra de progreso (opcional) --}}
    @php
        $secc = [
            'personas'      => ($formulario->salud ?? collect())->count() + ($formulario->afectadosIncendios ?? collect())->count(),
            'economico'     => ($formulario->sectoresAgricolas ?? collect())->count() + ($formulario->sectoresPecuarios ?? collect())->count() + ($formulario->areasForestales ?? collect())->count(),
            'servicios'     => ($formulario->infraestructuras ?? collect())->count() + ($formulario->serviciosBasicos ?? collect())->count() + ($formulario->educaciones ?? collect())->count(),
            'reporte'       => optional($formulario->reporteComunitario)->exists() ? 1 : 0,
            'asistencias'   => ($formulario->asistencias ?? collect())->count(),
            'reforestaciones'=> ($formulario->reforestaciones ?? collect())->count(),
        ];

        $totalRows = array_sum($secc);
        $totalExpected = 6;
        $percent = $totalExpected ? min(100, round($totalRows / $totalExpected * 100)) : 0;
    @endphp
    <div class="progress mb-4" style="height: 22px;">
        <div class="progress-bar progress-bar-success" style="width: {{ $percent }}%">
            {{ $percent }} % completado
        </div>
    </div>

    <div class="panel panel-bordered">
        <div class="panel-body">

            {{-- 4. Cinta de acceso rápido a secciones --}}
            @include('vendor.voyager.formularios.partials.botones-secciones')

            {{-- 1. Datos del formulario --}}
            @include('vendor.voyager.formularios.partials.datos-formulario')

            {{-- 2. Ubicación / mapa --}}
            @include('vendor.voyager.formularios.partials.ubicacion-mapa')

            {{-- 3. Datos del incendio --}}
            @include('vendor.voyager.formularios.partials.datos-incendio')


             {{-- 5. Secciones dinámicas (personas, infra, animales, económico) --}}
             {{-- @include('vendor.voyager.formularios.partials.per') --}}
            @include('vendor.voyager.formularios.partials.personas-matriz-show', ['grupoEtarios' => $grupoEtarios])
            @include('vendor.voyager.formularios.partials.salud-matriz-show', [
                'grupoEtarios' => $grupoEtarios,
                'enfermedades' => $enfermedades
            ])
            @include('vendor.voyager.formularios.partials.economico-show')
            {{-- @include('vendor.voyager.formularios.partials.personas-show') --}}
            @include('vendor.voyager.formularios.partials.servicios-show')
            @include('vendor.voyager.formularios.partials.reporte-show')
            @include('vendor.voyager.formularios.partials.reforestaciones-show')
            @include('vendor.voyager.formularios.partials.asistencias-show')


        </div>


        <div class="panel-footer text-right">
            <a href="{{ route('formularios.index') }}" class="btn btn-default">
                <i class="voyager-angle-left"></i> Volver
            </a>
            <a href="{{ route('formularios.edit', $formulario) }}" class="btn btn-primary">
                <i class="voyager-edit"></i> Editar
            </a>
            <button class="btn btn-danger" onclick="confirm('¿Eliminar este formulario?') ? document.getElementById('frm-delete').submit() : false">
                <i class="voyager-trash"></i> Eliminar
            </button>
            <form id="frm-delete" action="{{ route('formularios.destroy', $formulario) }}" method="POST" style="display:none">
                @csrf @method('DELETE')
            </form>
        </div>
    </div>
</div>
@stop
