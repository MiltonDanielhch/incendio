@props([
    'titulo',
    'id',
    'cabeceras',
    'colecciones',
    'namePrefix',
    'datosAnteriores',
    'columnas' => []
])

@php
    // Depuración: Verificar el tipo y contenido de $colecciones
    $tipoColecciones = gettype($colecciones);
    $esValido = false;

    if (is_array($colecciones) && count($colecciones) >= 2) {
        $esValido = isset($colecciones[0]) && isset($colecciones[1]) &&
                   is_iterable($colecciones[0]) && is_iterable($colecciones[1]);
    }

    // Log para depuración
    if (!$esValido) {
        \Log::debug('Error en formulario-tabla', [
            'titulo' => $titulo['texto'],
            'tipo_colecciones' => $tipoColecciones,
            'colecciones' => $colecciones
        ]);
    }
@endphp

<div class="panel-group" id="{{ $id }}">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#{{ $id }}" href="#collapse{{ $id }}">
          <i class="{{ $titulo['icon'] }}"></i> {{ $titulo['texto'] }}
        </a>
      </h4>
    </div>
    <div id="collapse{{ $id }}" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                @foreach($cabeceras as $cab)<th>{{ $cab }}</th>@endforeach
              </tr>
            </thead>
            <tbody>
              @if($esValido)
                @foreach($colecciones[0] as $grupo)
                  @foreach($colecciones[1] as $item)
                    @php
                      $key = $grupo->id . '.' . $item->id;
                      $prev = $datosAnteriores->first(fn($d) =>
                            $d->grupo_etario_id == $grupo->id && $d->catalogo_id == $item->id
                      );
                    @endphp
                    <tr>
                      <td>{{ $grupo->nombre }}</td>
                      <td>{{ $item->nombre }}</td>

                      {{-- Cantidad --}}
                      <td>
                        <input type="number" name="{{ $namePrefix }}[{{ $key }}][cantidad]" min="0"
                          value="{{ old($namePrefix . '.' . $key . '.cantidad', $prev->cantidad_enfermos ?? 0) }}"
                          class="form-control">
                      </td>

                      {{-- Gravedad (solo si la columna existe) --}}
                      @if(in_array('gravedad', array_keys($columnas)))
                        <td>
                          <select name="{{ $namePrefix }}[{{ $key }}][gravedad]" class="form-control">
                            @for($i=1; $i<=5; $i++)
                              <option value="{{ $i }}"
                                {{ old($namePrefix . '.' . $key . '.gravedad', $prev->gravedad_promedio ?? 3) == $i ? 'selected' : '' }}>
                                {{ $i }}
                              </option>
                            @endfor
                          </select>
                        </td>
                      @endif

                      {{-- Tratamiento (solo si la columna existe) --}}
                      @if(in_array('tratamiento', array_keys($columnas)))
                        <td>
                          <input type="text" name="{{ $namePrefix }}[{{ $key }}][tratamiento]"
                            value="{{ old($namePrefix . '.' . $key . '.tratamiento', $prev->tratamiento_requerido ?? '') }}"
                            class="form-control" placeholder="{{ $columnas['tratamiento'] }}">
                        </td>
                      @endif

                      {{-- Guardamos claves foráneas --}}
                      <input type="hidden" name="{{ $namePrefix }}[{{ $key }}][grupo_etario_id]" value="{{ $grupo->id }}">
                      <input type="hidden" name="{{ $namePrefix }}[{{ $key }}][catalogo_id]" value="{{ $item->id }}">
                    </tr>
                  @endforeach
                @endforeach
              @else
                <tr>
                  <td colspan="{{ count($cabeceras) }}" class="text-center text-danger">
                    <strong>Error en la tabla {{ $titulo['texto'] }}:</strong><br>
                    <small>
                      Tipo de datos recibido: {{ $tipoColecciones }}<br>
                      Valor: {{ is_string($colecciones) ? $colecciones : 'No es una cadena' }}
                    </small>
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
