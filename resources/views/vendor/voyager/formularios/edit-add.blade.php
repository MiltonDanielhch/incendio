@php
    $formulario = $formulario ?? null;
@endphp

@extends('voyager::master')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .table th{background-color:#f8f9fa}
    #mapaPicker{height:350px;border:1px solid #ccc;border-radius:4px}
</style>
@stop

@section('page_title', isset($formulario) ? 'Editar formulario' : 'Crear formulario')
@section('page_header')
<h1 class="page-title"><i class="voyager-fire"></i> {{ isset($formulario) ? 'Editar' : 'Crear' }} formulario de incendio</h1>
@stop

@section('content')
<div class="page-content edit-add container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ isset($formulario) ? route('formularios.update', $formulario->id) : route('formularios.store') }}">
                        @csrf
                        @if(isset($formulario)) @method('PUT') @endif

                        {{-- 1. FORMULARIO --}}
                        <h5>📋 Información del Formulario</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Encuestador</label>
                                <input type="text" name="nombre_encuestador" class="form-control"
                                       value="{{ old('nombre_encuestador', $formulario->nombre_encuestador ?? auth()->user()->name) }}">
                            </div>
                            <div class="col-md-4">
                                <label>Contacto</label>
                                <input type="text" name="contacto_encuestador" class="form-control"
                                       value="{{ old('contacto_encuestador', $formulario->contacto_encuestador ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label>Estado</label>
                                <select name="estado" class="form-control">
                                    @foreach(['borrador','completado','validado','rechazado'] as $est)
                                        <option value="{{ $est }}" {{ old('estado', $formulario->estado ?? 'completado') == $est ? 'selected' : '' }}>{{ ucfirst($est) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr>

                        {{-- 2. UBICACIÓN --}}
                        <h5>🌍 Ubicación Geográfica</h5>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Fecha llenado</label>
                                <input type="date" name="fecha_llenado" class="form-control"
                                       value="{{ old('fecha_llenado', isset($formulario) ? $formulario->fecha_llenado->format('Y-m-d') : date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <x-select-cascada id="provincia_id" name="provincia_id" label="Provincia"
                                                :options="$provincias"
                                                :selected="old('provincia_id', $formulario->comunidad->municipio->provincia_id ?? null)"/>
                            </div>
                            <div class="col-md-3">
                                <x-select-cascada id="municipio_id" name="municipio_id" label="Municipio"
                                                :options="isset($formulario) ? $formulario->comunidad->municipio->provincia->municipios : collect()"
                                                :selected="old('municipio_id', $formulario->comunidad->municipio_id ?? '')"
                                                parent="provincia_id"
                                                route="{{ route('admin.formulario.buscar_municipio','') }}"
                                                :disabled="!isset($formulario) && !old('provincia_id')"/>
                            </div>
                            <div class="col-md-4">
                                <label>Comunidad</label>
                                <div class="input-group">
                                    <x-select-cascada id="comunidad_id" name="comunidad_id" label=""
                                                    :options="isset($formulario) ? $formulario->comunidad->municipio->comunidades : collect()"
                                                    :selected="old('comunidad_id', $formulario->comunidad_id ?? '')"
                                                    parent="municipio_id"
                                                    route="{{ route('admin.formulario.buscar_comunidad','') }}"
                                                    :disabled="!isset($formulario) && !old('municipio_id')"
                                                    class="form-control" />
                                    <span class="input-group-btn">
                                        <button type="button" id="btnNuevaComunidad" class="btn btn-success" disabled>
                                            <i class="voyager-plus"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- 3. INCENDIO --}}
                        <h5>🔥 Datos del Incendio</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Inicio</label>
                                <input type="datetime-local" name="fecha_inicio" class="form-control"
                                       max="{{ now()->format('Y-m-d\TH:i') }}"
                                       value="{{ old('fecha_inicio', optional(optional($formulario)->incendio)->fecha_inicio?->format('Y-m-d\TH:i') ?? '') }}"
                                       required>
                            </div>
                            <div class="col-md-3">
                                <label>Fin (opc.)</label>
                                <input type="datetime-local" name="fecha_fin" class="form-control"
                                       max="{{ now()->format('Y-m-d\TH:i') }}"
                                       value="{{ old('fecha_fin', optional(optional($formulario)->incendio)->fecha_fin?->format('Y-m-d\TH:i') ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Estado</label>
                                <select name="incendio_estado" class="form-control">
                                    @foreach(['activo','controlado','extinguido'] as $e)
                                        <option value="{{ $e }}" {{ old('incendio_estado', optional(optional($formulario)->incendio)->estado ?? 'activo') == $e ? 'selected' : '' }}>{{ ucfirst($e) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Gravedad</label>
                                <select name="nivel_gravedad" class="form-control">
                                    @foreach(['bajo','medio','alto','critico'] as $g)
                                        <option value="{{ $g }}" {{ old('nivel_gravedad', optional(optional($formulario)->incendio)->nivel_gravedad ?? 'medio') == $g ? 'selected' : '' }}>{{ ucfirst($g) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Dirección aprox.</label>
                                <input type="text" name="direccion_manual" id="direccion_manual" class="form-control"
                                       value="{{ old('direccion_manual', optional(optional(optional($formulario)->incendio)->ubicacion)->direccion ?? '') }}"
                                       placeholder="Ej: Km 12 ruta 40">
                                <small class="text-muted">Hacé clic en el mapa para obtener latitud y longitud</small>
                            </div>

                            @php
                                $lat = null; $lon = null;
                                if (optional(optional($formulario)->incendio)->ubicacion) {
                                    $raw = \DB::select("SELECT ST_Y(coordenadas) AS lat, ST_X(coordenadas) AS lon FROM ubicaciones WHERE id = ?", [optional(optional($formulario)->incendio)->ubicacion->id])[0] ?? null;
                                    if ($raw) { $lat = $raw->lat; $lon = $raw->lon; }
                                }
                            @endphp

                            <div class="col-md-3">
                                <label>Latitud</label>
                                <input type="number" step="0.000001" name="lat" id="lat" class="form-control"
                                       value="{{ old('lat', $lat) }}" placeholder="-24.123456">
                            </div>
                            <div class="col-md-3">
                                <label>Longitud</label>
                                <input type="number" step="0.000001" name="lon" id="lon" class="form-control"
                                       value="{{ old('lon', $lon) }}" placeholder="-65.654321">
                            </div>
                        </div>

                        {{-- Mapa interactivo --}}
                        <div class="row">
                            <div class="col-md-12">
                                <label>Seleccioná la ubicación en el mapa</label>
                                <div id="mapaPicker"></div>
                                <br>
                                <button type="button" id="btnMiUbicacion" class="btn btn-sm btn-info">
                                    <i class="voyager-location"></i> Usar mi ubicación actual
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Causas probables</label>
                                <textarea name="causas_probables" class="form-control" rows="2">{{ old('causas_probables', optional(optional($formulario)->incendio)->causas_probables ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label>Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones', optional(optional($formulario)->incendio)->observaciones ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group text-right" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="voyager-check"></i> {{ isset($formulario) ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Nueva Comunidad --}}
<div class="modal fade" id="modalNuevaComunidad" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva comunidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="formNuevaComunidad">
            <input type="hidden" id="municipio_id_modal">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" id="nombre_comunidad" required>
            </div>
            <div class="form-group">
                <label>Tipo</label>
                <select class="form-control" id="tipo_comunidad" required>
                    <option value="">Seleccione tipo</option>
                    <option value="urbana">Urbana</option>
                    <option value="rural">Rural</option>
                    <option value="intercultural">Intercultural</option>
                    <option value="campesina">Campesina</option>
                    <option value="indigena">Indígena</option>
                </select>
            </div>
            <div class="form-group">
                <label>Población aproximada</label>
                <input type="number" class="form-control" id="poblacion_comunidad" min="0">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardarComunidad">Guardar</button>
      </div>
    </div>
  </div>
</div>
@stop

@push('javascript')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script>
window.addEventListener('DOMContentLoaded', function () {
    (function ($) {

        // ---------- selects dependientes ----------
        function resetSelect(id, placeholder) {
            $('#' + id).empty().append('<option value="">' + placeholder + '</option>').prop('disabled', true);
        }
        $('#provincia_id').on('change', function () {
            let provId = $(this).val(), $muni = $('#municipio_id'), $comu = $('#comunidad_id');
            if (provId) {
                $muni.prop('disabled', true).html('<option value="">Cargando...</option>');
                $.get("{{ route('admin.formulario.buscar_municipio', '') }}/" + provId)
                    .done(function (data) {
                        $muni.prop('disabled', false).html('<option value="">Seleccione un municipio</option>');
                        $.each(data, (_, item) => { $muni.append($('<option>', {value: item.id, text: item.nombre})); });
                        $(document).trigger('provincia:loaded');
                    })
                    .fail(() => resetSelect('municipio_id', 'Error al cargar'));
            } else {
                resetSelect('municipio_id', 'Seleccione un municipio');
                resetSelect('comunidad_id', 'Seleccione una comunidad');
            }
        });
        $('#municipio_id').on('change', function () {
            let muniId = $(this).val(), $comu = $('#comunidad_id');
            if (muniId) {
                $comu.prop('disabled', true).html('<option value="">Cargando...</option>');
                $.get("{{ route('admin.formulario.buscar_comunidad', '') }}/" + muniId)
                    .done(function (data) {
                        $comu.prop('disabled', false).html('<option value="">Seleccione una comunidad</option>');
                        $.each(data, (_, item) => { $comu.append($('<option>', {value: item.id, text: item.nombre})); });
                        $(document).trigger('municipio:loaded');
                    })
                    .fail(() => resetSelect('comunidad_id', 'Error al cargar'));
            } else {
                resetSelect('comunidad_id', 'Seleccione una comunidad');
            }
        });

        @if(isset($formulario))
            const provId = {{ $formulario->comunidad->municipio->provincia_id ?? 'null' }};
            const muniId = {{ $formulario->comunidad->municipio_id       ?? 'null' }};
            const comuId = {{ $formulario->comunidad_id                ?? 'null' }};
            if (provId) {
                $('#provincia_id').val(provId).trigger('change');
                $(document).one('provincia:loaded', () => {
                    if (muniId) {
                        $('#municipio_id').val(muniId).trigger('change');
                        $(document).one('municipio:loaded', () => { if (comuId) $('#comunidad_id').val(comuId); });
                    }
                });
            }
        @endif

        // ---------- nueva comunidad ----------
        $('#municipio_id').on('change', function () {
            const muniId = $(this).val();
            $('#btnNuevaComunidad').prop('disabled', !muniId);
            $('#municipio_id_modal').val(muniId);
        });
        $('#btnNuevaComunidad').click(() => $('#modalNuevaComunidad').modal('show'));
        $('#guardarComunidad').click(function () {
            const data = {
                municipio_id: $('#municipio_id_modal').val(),
                nombre: $('#nombre_comunidad').val(),
                tipo_comunidad: $('#tipo_comunidad').val(),
                poblacion_aproximada: $('#poblacion_comunidad').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            if (!data.nombre || !data.tipo_comunidad) return toastr.error('Complete los campos obligatorios');
            $.post("{{ route('admin.comunidades.quick-store') }}", data)
                .done(res => {
                    $('#comunidad_id').append(new Option(res.nombre, res.id, false, true));
                    $('#modalNuevaComunidad').modal('hide');
                    $('#formNuevaComunidad')[0].reset();
                    toastr.success('Comunidad creada');
                })
                .fail(xhr => toastr.error('Error al guardar: ' + (xhr.responseJSON.message || 'Desconocido')));
        });

        // ---------- mapa ----------
        let mapPicker, marker;
        const defaultCenter = [-24.123456, -65.654321];
        function initMapPicker() {
            mapPicker = L.map('mapaPicker').setView(defaultCenter, 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(mapPicker);
            const lat = parseFloat($('#lat').val()) || defaultCenter[0];
            const lon = parseFloat($('#lon').val()) || defaultCenter[1];
            if (!isNaN(lat) && !isNaN(lon)) {
                mapPicker.setView([lat, lon], 13);
                marker = L.marker([lat, lon]).addTo(mapPicker);
            }
            mapPicker.on('click', function (ev) {
                const {lat, lng} = ev.latlng;
                $('#lat').val(lat.toFixed(6));
                $('#lon').val(lng.toFixed(6));
                if (marker) mapPicker.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(mapPicker);
                reverseGeocode(lat, lng);
            });
        }
        $('#btnMiUbicacion').on('click', () => {
            if (!navigator.geolocation) return toastr.error('Tu navegador no soporta geolocalización');
            navigator.geolocation.getCurrentPosition(
                pos => {
                    const lat = pos.coords.latitude, lon = pos.coords.longitude;
                    $('#lat').val(lat.toFixed(6));
                    $('#lon').val(lon.toFixed(6));
                    if (marker) mapPicker.removeLayer(marker);
                    marker = L.marker([lat, lon]).addTo(mapPicker);
                    mapPicker.setView([lat, lon], 15);
                    reverseGeocode(lat, lon);
                },
                err => toastr.error('No se pudo obtener tu ubicación: ' + err.message),
                {enableHighAccuracy: true, timeout: 10000}
            );
        });
        function reverseGeocode(lat, lon) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.display_name) {
                        const direccion = data.display_name.split(',').slice(0, 3).join(',').trim();
                        $('#direccion_manual').val(direccion);
                    } else {
                        $('#direccion_manual').val('');
                    }
                })
                .catch(err => {
                    console.warn('Error reverse geocoding:', err);
                    $('#direccion_manual').val('');
                });
        }
        initMapPicker();
    })(window.jQuery);
});
</script>
@endpush
