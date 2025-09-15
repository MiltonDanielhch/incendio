@extends('voyager::master')

@section('page_title', 'Ver formulario de incendio')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-fire"></i> Formulario N° {{ $formulario->codigo_formulario }}
    </h1>
@stop

@section('content')
<div class="page-content container-fluid">
    <div class="panel panel-bordered">
        <div class="panel-body">

            {{-- 1. DATOS DEL FORMULARIO --}}
            <h4>📋 Información del formulario</h4>
            <table class="table table-bordered">
                <tr><th width="200">Código</th><td>{{ $formulario->codigo_formulario }}</td></tr>
                <tr><th>Estado</th><td>{{ ucfirst($formulario->estado) }}</td></tr>
                <tr><th>Fecha de llenado</th><td>{{ $formulario->fecha_llenado->format('d/m/Y') }}</td></tr>
                <tr><th>Encuestador</th><td>{{ $formulario->nombre_encuestador }} - {{ $formulario->contacto_encuestador }}</td></tr>
                <tr><th>Comunidad</th>
                    <td>{{ $formulario->comunidad->nombre }}
                        ({{ $formulario->comunidad->municipio->nombre }},
                        {{ $formulario->comunidad->municipio->provincia->nombre }})
                    </td>
                </tr>
            </table>

            <hr>

            {{-- 2. UBICACIÓN DEL INCENDIO --}}
            <h4>🌍 Ubicación del incendio</h4>

            @php
                $lat = null;
                $lon = null;
                if ($formulario->incendio->ubicacion) {
                    // Leer el POINT sin pasar por el mutador
                    $raw = DB::select("SELECT ST_Y(coordenadas) AS lat, ST_X(coordenadas) AS lon FROM ubicaciones WHERE id = ?", [$formulario->incendio->ubicacion->id])[0] ?? null;
                    if ($raw) {
                        $lat = $raw->lat;
                        $lon = $raw->lon;
                    }
                    // Descartar punto vacío
                    if ($lat == 0 && $lon == 0) {
                        $lat = $lon = null;
                    }
                }
            @endphp

            @if($formulario->incendio->ubicacion)
                <table class="table table-bordered">
                    <tr><th width="200">Dirección / Referencia</th>
                        <td>{{ $formulario->incendio->ubicacion->direccion ?? 'Sin referencia' }}</td>
                    </tr>
                    @if($lat && $lon)
                        <tr><th>Latitud</th><td>{{ number_format($lat, 6) }}</td></tr>
                        <tr><th>Longitud</th><td>{{ number_format($lon, 6) }}</td></tr>
                    @else
                        <tr><th colspan="2">Sin coordenadas registradas</th></tr>
                    @endif
                </table>

                @if($lat && $lon)
                    <div id="mapa" style="height: 350px; border: 1px solid #ccc;"></div>
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                    <script>
                        var map = L.map('mapa').setView([{{ $lat }}, {{ $lon }}], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap'
                        }).addTo(map);
                        L.marker([{{ $lat }}, {{ $lon }}]).addTo(map)
                            .bindPopup("Incendio {{ $formulario->incendio->codigo_incendio }}");
                    </script>
                @endif
            @else
                <p>No se registró ubicación para este incendio.</p>
            @endif
            <hr>

            {{-- 3. DATOS DEL INCENDIO --}}
            <h4>🔥 Datos del incendio</h4>
            <table class="table table-bordered">
                <tr><th width="200">Código incendio</th><td>{{ $formulario->incendio->codigo_incendio }}</td></tr>
                <tr><th>Inicio</th><td>{{ $formulario->incendio->fecha_inicio->format('d/m/Y H:i') }}</td></tr>
                <tr><th>Fin</th><td>{{ $formulario->incendio->fecha_fin?->format('d/m/Y H:i') ?? 'No finalizado' }}</td></tr>
                <tr><th>Estado</th><td>{{ ucfirst($formulario->incendio->estado) }}</td></tr>
                <tr><th>Gravedad</th><td>{{ ucfirst($formulario->incendio->nivel_gravedad) }}</td></tr>
                <tr><th>Área afectada</th><td>{{ $formulario->incendio->area_afectada_ha ?? 'No registrada' }} ha</td></tr>
                <tr><th>Causas probables</th><td>{{ $formulario->incendio->causas_probables ?? 'No registradas' }}</td></tr>
                <tr><th>Observaciones</th><td>{{ $formulario->incendio->observaciones ?? 'Sin observaciones' }}</td></tr>
            </table>

        </div>{{-- /.panel-body --}}

        <div class="panel-footer text-right">
            <a href="{{ route('formularios.index') }}" class="btn btn-default">Volver</a>
            <a href="{{ route('formularios.edit', $formulario) }}" class="btn btn-primary">Editar</a>
            <button class="btn btn-danger" onclick="confirm('¿Eliminar este formulario?') ? document.getElementById('frm-delete').submit() : false">Eliminar</button>
            <form id="frm-delete" action="{{ route('formularios.destroy', $formulario) }}" method="POST" style="display:none">
                @csrf @method('DELETE')
            </form>
        </div>
    </div>
</div>

{{-- MAPA LEAFLET --}}
@if($lat && $lon)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('mapa').setView([{{ $lat }}, {{ $lon }}], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    L.marker([{{ $lat }}, {{ $lon }}]).addTo(map)
        .bindPopup("Incendio {{ $formulario->incendio->codigo_incendio }}");
</script>
@endif
@stop
