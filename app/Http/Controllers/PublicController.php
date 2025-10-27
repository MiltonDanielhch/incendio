<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\Incendio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AfectadoIncendio;
use App\Models\SectorAgricola;
use App\Models\SectorPecuario;
use App\Models\AreaForestal;
use App\Models\Infraestructura;

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
        $stats['familias_afectadas'] = \App\Models\ReporteComunitario::sum('num_familias_afectadas');
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

        // 3.1 Rellenar meses sin datos para un gráfico continuo
        $meses = collect();
        for ($i = 11; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $meses[$mes->format('Y-m')] = 0;
        }
        $stats['reportes_por_mes'] = $meses->merge($formulariosPorMes);

        // 4. Datos para el Mapa Interactivo (Incendios activos y controlados con ubicación)
        // Optimizado para evitar N+1 queries y usar Eloquent directamente
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

        // 6. Nuevas estadísticas de impacto desde los formularios
        $stats['total_personas_afectadas'] = AfectadoIncendio::sum('cantidad_afectados') + AfectadoIncendio::sum('cantidad_lesionados') + AfectadoIncendio::sum('cantidad_fallecidos');
        $stats['total_personas_fallecidas'] = AfectadoIncendio::sum('cantidad_fallecidos');
        $stats['comunidades_afectadas'] = Formulario::distinct('comunidad_id')->count();

        // 7. Datos para el nuevo gráfico de pérdidas económicas
        $perdidas['agricola'] = SectorAgricola::sum('valor_estimado_perdida');
        $perdidas['pecuario'] = SectorPecuario::sum('valor_estimado_perdida');
        $perdidas['forestal'] = AreaForestal::sum('valor_estimado_perdida');
        $perdidas['infraestructura'] = Infraestructura::sum('valor_estimado_perdida');

        $stats['perdida_economica_total'] = array_sum($perdidas);
        $stats['perdidas_por_sector'] = $perdidas;


        return view('home', compact(
            'stats',
            'incendiosParaMapa',
            'ultimosFormularios'
        ));
    }
}
