<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Fecha Llenado</th>
                    <th>Ubicación</th>
                    <th>Incendio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $formulario)
                    <tr>
                        <td>{{ $formulario->id }}</td>
                        <td>{{ $formulario->codigo_formulario }}</td>
                        <td>{{ $formulario->fecha_llenado }}</td>
                        <td>
                            @if($formulario->comunidad && $formulario->comunidad->municipio && $formulario->comunidad->municipio->provincia)
                                <strong>Provincia:</strong> {{ $formulario->comunidad->municipio->provincia->nombre }} <br>
                                <strong>Municipio:</strong> {{ $formulario->comunidad->municipio->nombre }} <br>
                                <strong>Comunidad:</strong> {{ $formulario->comunidad->nombre }} <br>
                                <strong>Tipo:</strong> {{ $formulario->comunidad->tipo_comunidad }}
                            @else
                                Información no disponible
                            @endif
                        </td>
                        <td>
                            @if($formulario->incendio)
                                <strong>Fecha Inicio:</strong> {{ $formulario->incendio->fecha_inicio }} <br>
                                <strong>Estado:</strong> {{ $formulario->incendio->estado }} <br>
                                <strong>Gravedad:</strong> {{ $formulario->incendio->nivel_gravedad }}
                            @else
                                Información no disponible
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{
                                $formulario->estado == 'completado' ? 'success' :
                                ($formulario->estado == 'validado' ? 'primary' :
                                ($formulario->estado == 'borrador' ? 'warning' : 'danger'))
                            }}">
                                {{ $formulario->estado }}
                            </span>
                        </td>
                        <td class="no-sort no-click text-right">
                            <a href="{{ route('formularios.ver', $formulario->id) }}"
                            title="Ver"
                            class="btn btn-sm btn-warning view">
                                <i class="voyager-eye"></i>
                                <span class="hidden-xs hidden-sm">Ver</span>
                            </a>
                            {{-- @if(auth()->user()->hasPermission('edit_formularios')) --}}
                                <a href="{{ route('formularios.edit', $formulario->id) }}" title="Editar" class="btn btn-sm btn-primary edit">
                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                </a>
                            {{-- @endif --}}
                            @if(auth()->user()->hasPermission('delete_formularios'))
                                <button title="Borrar" class="btn btn-sm btn-danger delete" data-toggle="modal" data-target="#delete_modal" onclick="deleteItem('{{ route('formularios.destroy', $formulario->id) }}')">
                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                </button>
                            @endif
                            {{-- @if($item->trashed())
                                <form action="{{ route('formularios.restore', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-warning"
                                            title="Restaurar"
                                            onclick="return confirm('¿Restaurar este formulario y todos sus datos?')">
                                        <i class="voyager-refresh"></i> Restaurar
                                    </button>
                                </form>
                            @endif --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4" style="overflow-x:auto">
        @if(count($data)>0)
            <p class="text-muted">Mostrando del {{$data->firstItem()}} al {{$data->lastItem()}} de {{$data->total()}} registros.</p>
        @endif
    </div>
    <div class="col-md-8" style="overflow-x:auto">
        <nav class="text-right">
            {{ $data->links() }}
        </nav>
    </div>
</div>

<script>
$('.page-link').click(function(e){
    e.preventDefault();
    let link = $(this).attr('href');
    if(link){
        page = link.split('=')[1];
        list(page);
    }
});
</script>
