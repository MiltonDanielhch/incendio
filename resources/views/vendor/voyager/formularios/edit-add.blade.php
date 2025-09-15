@extends('voyager::master')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .panel-heading a:after{font-family:'Glyphicons Halflings';content:"\e114";float:right;color:grey}
    .panel-heading a.collapsed:after{content:"\e080"}
    .table th{background-color:#f8f9fa}
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
                        <div class="alert alert-danger"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <form action="{{ isset($formulario) ? route('formularios.update', $formulario->id) : route('formularios.store') }}" method="POST">
                        {{-- <pre>{{ print_r(old(), true) }}</pre> --}}
                        {{-- Mostrar todos los errores de validación --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @csrf
                        @if(isset($formulario)) @method('PUT') @endif


                        <div class="panel-group" id="accordionLugar">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordionLugar" href="#collapseLugar"><i class="voyager-location"></i> Información Geográfica</a>
                                    </h4>
                                </div>
                                <div id="collapseLugar" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Nombre del encuestador</label>
                                                    <input type="text" name="nombre_encuestador" class="form-control"
                                                           value="{{ old('nombre_encuestador', $formulario->nombre_encuestador ?? auth()->user()->name) }}">
                                                </div>
                                            </div>
                                            {{-- Contacto del encuestador --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Contacto del encuestador</label>
                                                    <input type="text" name="contacto_encuestador" class="form-control"
                                                        value="{{ old('contacto_encuestador', $formulario->contacto_encuestador ?? '') }}">
                                                </div>
                                                {{-- Estado del formulario --}}
                                                <div class="form-group">
                                                    <label>Estado del formulario</label>
                                                    <select name="estado" class="form-control">
                                                        @foreach(['borrador','completado','validado','rechazado'] as $est)
                                                            <x-option-selected :value="$est" :selected="old('estado', $formulario->estado ?? 'completado')">{{ ucfirst($est) }}</x-option-selected>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- =======  SECCIÓN 1: GEOGRÁFICA  ======= -->
                        <div class="panel-group" id="accordionLugar">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordionLugar" href="#collapseLugar"><i class="voyager-location"></i> Información Geográfica</a>
                                    </h4>
                                </div>
                                <div id="collapseLugar" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Fecha de llenado</label>
                                                    <input type="date" name="fecha_llenado" class="form-control"
                                                           value="{{ old('fecha_llenado', isset($formulario) ? $formulario->fecha_llenado->format('Y-m-d') : date('Y-m-d')) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <x-select-cascada
                                                    id="provincia_id" name="provincia_id" label="Provincia"
                                                    :options="$provincias"
                                                    :selected="old('provincia_id', $formulario->comunidad->municipio->provincia_id ?? null)"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <x-select-cascada
                                                    id="municipio_id" name="municipio_id" label="Municipio"
                                                    :options="isset($formulario) ? $formulario->comunidad->municipio->provincia->municipios : collect()"
                                                    :selected="old('municipio_id', $formulario->comunidad->municipio_id ?? '')"
                                                    parent="provincia_id"
                                                    route="{{ route('admin.formulario.buscar_municipio','') }}"
                                                    :disabled="!isset($formulario)"
                                                />
                                            </div>
                                            <div class="col-md-4">
                                                <label>Comunidad</label>
                                                <div class="input-group" style="align-items: flex-end;">
                                                    <x-select-cascada
                                                        id="comunidad_id"
                                                        name="comunidad_id"
                                                        label=""
                                                        :options="isset($formulario) ? $formulario->comunidad->municipio->comunidades : collect()"
                                                        :selected="old('comunidad_id', $formulario->comunidad_id ?? '')"
                                                        parent="municipio_id"
                                                        route="{{ route('admin.formulario.buscar_comunidad','') }}"
                                                        :disabled="!isset($formulario)"
                                                        class="form-control"
                                                    />
                                                    <span class="input-group-btn">
                                                        <button type="button" id="btnNuevaComunidad"
                                                                class="btn btn-success btn-md"
                                                                title="Añadir nueva comunidad"
                                                                style="height: 34px; margin-left: 6px;" disabled>
                                                            <i class="voyager-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- =======  SECCIÓN 2: INCENDIO  ======= -->
                      <!-- =======  SECCIÓN 2: INCENDIO  ======= -->
                        <div class="panel-group" id="accordionIncendio">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordionIncendio" href="#collapseIncendio" aria-expanded="true" aria-controls="collapseIncendio">
                                            <i class="voyager-fire" aria-hidden="true"></i>
                                            <span class="sr-only">Icono de incendio</span>
                                            Información del Incendio
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseIncendio" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingIncendio">
                                    <div class="panel-body">
                                        <div class="row">
                                            {{-- Código oculto (se genera automáticamente) --}}
                                            <input type="hidden" name="codigo_incendio" value="{{ old('codigo_incendio') }}">

                                            <div class="col-md-3">
                                                <!-- Fecha/hora de inicio -->
                                                <div class="form-group">
                                                    <label for="fecha_inicio">Fecha y hora de inicio <span class="text-danger">*</span></label>
                                                    <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                                        max="{{ now()->format('Y-m-d\TH:i') }}"
                                                        value="{{ old('fecha_inicio') }}" required>
                                                </div>

                                                <!-- Fecha/hora de fin -->
                                                <div class="form-group">
                                                    <label for="fecha_fin">Fecha y hora de finalización (opcional)</label>
                                                    <input type="datetime-local" name="fecha_fin" id="fecha_fin" class="form-control"
                                                        max="{{ now()->format('Y-m-d\TH:i') }}"
                                                        value="{{ old('fecha_fin') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <!-- Estado del INCENDIO -->
                                                <div class="form-group">
                                                    <label for="incendio_estado">Estado del incendio</label>
                                                    <select name="incendio_estado" id="incendio_estado" class="form-control">
                                                        @foreach(['activo', 'controlado', 'extinguido'] as $est)
                                                            <option value="{{ $est }}" {{ old('incendio_estado', 'activo') == $est ? 'selected' : '' }}>
                                                                {{ ucfirst($est) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Nivel de gravedad -->
                                                <div class="form-group">
                                                    <label for="nivel_gravedad">Nivel de gravedad</label>
                                                    <select name="nivel_gravedad" id="nivel_gravedad" class="form-control">
                                                        @foreach(['bajo', 'medio', 'alto', 'critico'] as $niv)
                                                            <option value="{{ $niv }}" {{ old('nivel_gravedad', 'medio') == $niv ? 'selected' : '' }}>
                                                                {{ ucfirst($niv) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Ubicación exacta del incendio -->
                                                <div class="form-group">
                                                    <label for="direccion_manual">Referencia / Dirección aproximada del incendio</label>
                                                    <input type="text" name="direccion_manual" id="direccion_manual" class="form-control"
                                                        placeholder="Ej: Km 12 ruta 40, entrada al pueblo">
                                                </div>

                                                <!-- Coordenadas opcionales -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="lat">Latitud <small>(opcional, puedes pegar desde Google Maps)</small></label>
                                                        <input type="number" step="0.000001" name="lat" id="lat" class="form-control"
                                                            placeholder="-24.123456" value="{{ old('lat') }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="lon">Longitud <small>(opcional)</small></label>
                                                        <input type="number" step="0.000001" name="lon" id="lon" class="form-control"
                                                            placeholder="-65.654321" value="{{ old('lon') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Causas probables -->
                                                <div class="form-group">
                                                    <label for="causas_probables">Causas probables</label>
                                                    <textarea name="causas_probables" id="causas_probables" class="form-control" rows="3">{{ old('causas_probables') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Observaciones -->
                                                <div class="form-group">
                                                    <label for="observaciones">Observaciones adicionales</label>
                                                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary btn-lg" aria-label="Guardar formulario de incendio">
                                <i class="voyager-check" aria-hidden="true"></i>
                                <span class="sr-only">Icono guardar</span>
                                {{ isset($formulario) ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Comunidad -->
<div class="modal fade" id="modalNuevaComunidad" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Nueva comunidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formNuevaComunidad">
            <input type="hidden" id="municipio_id_modal" value="">
            <div class="form-group">
                <label for="nombre_comunidad">Nombre</label>
                <input type="text" class="form-control" id="nombre_comunidad" required>
            </div>
            <div class="form-group">
                <label for="tipo_comunidad">Tipo</label>
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
                <label for="poblacion_comunidad">Población aproximada</label>
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
<script>
// Voyager dispara este evento cuando jQuery y sus plugins ya están cargados
window.addEventListener('DOMContentLoaded', function () {
    (function ($) {

        // helper para limpiar y deshabilitar
        function resetSelect(id, placeholder) {
            $('#' + id).empty().append('<option value="">' + placeholder + '</option>').prop('disabled', true);
        }

        // Provincia → Municipios
        $('#provincia_id').on('change', function () {
            let provId = $(this).val(),
                $muni  = $('#municipio_id'),
                $comu  = $('#comunidad_id');

            if (provId) {
                $muni.prop('disabled', true).html('<option value="">Cargando...</option>');
                $.get("{{ route('admin.formulario.buscar_municipio', '') }}/" + provId)
                    .done(function (data) {
                        $muni.prop('disabled', false)
                             .html('<option value="">Seleccione un municipio</option>');
                        $.each(data, (_, item) => {
                            $muni.append($('<option>', {value: item.id, text: item.nombre}));
                        });
                    })
                    .fail(() => resetSelect('municipio_id', 'Error al cargar'));
            } else {
                resetSelect('municipio_id', 'Seleccione un municipio');
                resetSelect('comunidad_id', 'Seleccione una comunidad');
            }
        });

        // Municipio → Comunidades
        $('#municipio_id').on('change', function () {
            let muniId = $(this).val(),
                $comu  = $('#comunidad_id');

            if (muniId) {
                $comu.prop('disabled', true).html('<option value="">Cargando...</option>');
                $.get("{{ route('admin.formulario.buscar_comunidad', '') }}/" + muniId)
                    .done(function (data) {
                        $comu.prop('disabled', false)
                             .html('<option value="">Seleccione una comunidad</option>');
                        $.each(data, (_, item) => {
                            $comu.append($('<option>', {value: item.id, text: item.nombre}));
                        });
                    })
                    .fail(() => resetSelect('comunidad_id', 'Error al cargar'));
            } else {
                resetSelect('comunidad_id', 'Seleccione una comunidad');
            }
        });

        // Solo si estamos editando y existen los IDs
        @if(isset($formulario))
            (function(){
                // Usamos el operador ternario para asegurarnos de que el valor sea 'null' si no existe
                // para que JavaScript lo maneje correctamente.
                const provId = {{ $formulario->comunidad->municipio->provincia_id ?? 'null' }};
                const muniId = {{ $formulario->comunidad->municipio_id       ?? 'null' }};
                const comuId = {{ $formulario->comunidad_id                ?? 'null' }};

                // Si hay un valor válido para provincia, lo establecemos
                if (provId) {
                    $('#provincia_id').val(provId).trigger('change');
                }

                // Usamos un retraso para dar tiempo a que los municipios se carguen
                setTimeout(() => {
                    // Si hay un valor válido para el municipio, lo establecemos
                    if (muniId) {
                        $('#municipio_id').val(muniId).trigger('change');
                    }
                }, 300);

                // Usamos otro retraso para dar tiempo a que las comunidades se carguen
                setTimeout(() => {
                    // Si hay un valor válido para la comunidad, lo establecemos
                    if (comuId) {
                        $('#comunidad_id').val(comuId);
                    }
                }, 600);
            })();
        @endif
    })(window.jQuery);
});

// Habilitar/deshabilitar botón según municipio seleccionado
$('#municipio_id').on('change', function () {
    const muniId = $(this).val();
    if (muniId) {
        $('#btnNuevaComunidad').prop('disabled', false);
        $('#municipio_id_modal').val(muniId);
    } else {
        $('#btnNuevaComunidad').prop('disabled', true);
    }
});

// Abrir modal
$('#btnNuevaComunidad').click(function () {
    $('#modalNuevaComunidad').modal('show');
});

// Guardar nueva comunidad vía AJAX
$('#guardarComunidad').click(function () {
    const data = {
        municipio_id: $('#municipio_id_modal').val(),
        nombre: $('#nombre_comunidad').val(),
        tipo_comunidad: $('#tipo_comunidad').val(),
        poblacion_aproximada: $('#poblacion_comunidad').val(),
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    if (!data.nombre || !data.tipo_comunidad) {
        toastr.error('Complete los campos obligatorios');
        return;
    }

    $.post("{{ route('admin.comunidades.quick-store') }}", data)
        .done(function (res) {
            // Añadir nueva opción al select y seleccionarla
            $('#comunidad_id').append(new Option(res.nombre, res.id, false, true));
            $('#modalNuevaComunidad').modal('hide');
            // Limpiar modal
            $('#formNuevaComunidad')[0].reset();
            toastr.success('Comunidad creada');
        })
        .fail(function (xhr) {
            toastr.error('Error al guardar: ' + (xhr.responseJSON.message || 'Desconocido'));
        });
});
</script>
@endpush


