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
        // Optimizado para evitar N+1 queries
        $incendiosParaMapa = Incendio::join('ubicaciones', 'incendios.ubicacion_id', '=', 'ubicaciones.id')
            ->whereIn('estado', ['activo', 'controlado'])
            ->whereNotNull('ubicaciones.coordenadas')
            ->select(
                'incendios.id', 'incendios.codigo_incendio', 'incendios.estado', 'incendios.nivel_gravedad', 'incendios.fecha_inicio',
                DB::raw('ST_Y(ubicaciones.coordenadas) as lat'),
                DB::raw('ST_X(ubicaciones.coordenadas) as lon')
            )
            ->get();

        // 5. Últimos formularios registrados para la tabla
        $ultimosFormularios = Formulario::with(['comunidad.municipio', 'incendio'])
            ->orderBy('fecha_llenado', 'desc')
            ->limit(10)
            ->get();


        return view('home', compact('stats', 'incendiosParaMapa', 'ultimosFormularios'));
    }
}
