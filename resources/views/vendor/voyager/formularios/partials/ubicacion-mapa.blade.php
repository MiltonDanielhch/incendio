{{-- 2. UBICACIÓN DEL INCENDIO --}}
<h4>🌍 Ubicación del incendio</h4>
@php
    $ubi = $formulario->incendio->ubicacion;
    $parsed = $ubi?->coordenadas;          // tu parser corregido
    $lat = $parsed['latitud']  ?? null;
    $lon = $parsed['longitud'] ?? null;

    // Descartar (0,0)
    if ($lat == 0 && $lon == 0)  $lat = $lon = null;
@endphp

@if($ubi && $lat && $lon)
    <table class="table table-bordered">
        <tr><th width="200">Dirección / Referencia</th>
            <td>{{ $ubi->direccion ?? 'Sin referencia' }}</td>
        </tr>
        <tr><th>Latitud</th><td>{{ number_format($lat, 6) }}</td></tr>
        <tr><th>Longitud</th><td>{{ number_format($lon, 6) }}</td></tr>
    </table>

    <div id="mapa" style="height: 350px; border: 1px solid #ccc;"></div>
    @push('javascript')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            var map = L.map('mapa').setView([{{ $lat }}, {{ $lon }}], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);
            L.marker([{{ $lat }}, {{ $lon }}]).addTo(map)
                .bindPopup("Incendio {{ $formulario->incendio->codigo_incendio }}");
        </script>
    @endpush
@else
    <p class="alert alert-warning">No se registró ubicación para este incendio.</p>
@endif
<hr>
