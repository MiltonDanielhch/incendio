<div class="panel-heading">
    <h3 class="panel-title"><i class="voyager-list"></i> Completar / revisar secciones</h3>
</div>
<div class="panel-body">
    <div class="row">
        @php
           $cards = [
                ['key'=>'personas',      'icon'=>'voyager-people',     'color'=>'primary', 'titulo'=>'PERSONAS'],
                ['key'=>'economico',     'icon'=>'voyager-bag',        'color'=>'success', 'titulo'=>'ACTIVIDADES ECONÓMICAS'],
                ['key'=>'servicios',     'icon'=>'voyager-home',       'color'=>'warning', 'titulo'=>'SERVICIOS E INFRAESTRUCTURA'],
                ['key'=>'reporte',       'icon'=>'voyager-documentation','color'=>'info',  'titulo'=>'REPORTE GENERAL'],
                ['key'=>'asistencias',   'icon'=>'voyager-basket',     'color'=>'dark',   'titulo'=>'ASISTENCIAS'],
                ['key'=>'reforestaciones','icon'=>'voyager-tree',      'color'=>'default','titulo'=>'REFORESTACIÓN'],
            ];
        @endphp
        @foreach($cards as $c)
            @php
                $count = $secc[$c['key']];
                $route = route('admin.formularios.'.$c['key'].'.edit-add', $formulario);
            @endphp
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="{{ $route }}" class="btn btn-block btn-{{ $c['color'] }}" style="white-space:normal;">
                    <i class="{{ $c['icon'] }}"></i><br>
                    <strong>{{ $c['titulo'] }}</strong><br>
                    <small>{{ $count }} registro{{ $count==1 ? '' : 's' }}</small>
                </a>
            </div>
        @endforeach
    </div>
</div>
