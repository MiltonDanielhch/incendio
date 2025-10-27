<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\Incendio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    /**
     * Muestra el dashboard público de incendios.
     */
    public function index()
    {
        // --- Recopilación de Datos para el Portal Público ---

        // 1. Tarjetas de Estadísticas
        $stats['incendios_activos'] = Incendio::where('estado', 'activo')->count();
        $stats['familias_afectadas'] = DB::table('reportes_comunitarios')->sum('num_familias_afectadas');
        $stats['ha_afectadas'] = Incendio::sum('area_afectada_ha');
        $stats['formularios_total'] = Formulario::count();

        // 2. Gráfico: Incendios por gravedad
        $stats['incendios_por_gravedad'] = Incendio::select('nivel_gravedad', DB::raw('count(*) as total'))
            ->groupBy('nivel_gravedad')
            ->pluck('total', 'nivel_gravedad');

        // 3. Gráfico: Formularios por mes (últimos 12 meses)
        $formulariosPorMes = Formulario::select(
                DB::raw("DATE_FORMAT(fecha_llenado, '%Y-%m') as mes"),
                DB::raw('count(*) as total')
            )
            ->where('fecha_llenado', '>=', Carbon::now()->subYear())
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get()
            ->pluck('total', 'mes');

        // Rellenar meses sin datos para un gráfico continuo
        $meses = collect();
        for ($i = 11; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $meses[$mes->format('Y-m')] = 0;
        }
        $stats['formularios_por_mes'] = $meses->merge($formulariosPorMes);

        // 4. Datos para el Mapa Interactivo (Incendios activos y controlados con ubicación)
        $incendiosParaMapa = Incendio::with('ubicacion')
            ->whereIn('estado', ['activo', 'controlado'])
            ->whereHas('ubicacion', function ($query) {
                $query->whereNotNull('coordenadas');
            })
            ->select('id', 'codigo_incendio', 'estado', 'nivel_gravedad', 'fecha_inicio', 'ubicacion_id')
            ->get()
            ->map(function ($incendio) {
                // Extraemos lat y lon del campo de geometría POINT
                $raw = DB::select("SELECT ST_Y(coordenadas) AS lat, ST_X(coordenadas) AS lon FROM ubicaciones WHERE id = ?", [$incendio->ubicacion_id])[0] ?? null;
                $incendio->lat = $raw ? $raw->lat : null;
                $incendio->lon = $raw ? $raw->lon : null;
                return $incendio;
            })->filter(fn($incendio) => $incendio->lat && $incendio->lon);

        // 5. Últimos formularios registrados para la tabla
        $ultimosFormularios = Formulario::with(['comunidad.municipio', 'incendio'])
            ->orderBy('fecha_llenado', 'desc')
            ->limit(10)
            ->get();


        return view('home', compact('stats', 'incendiosParaMapa', 'ultimosFormularios'));
    }
}
