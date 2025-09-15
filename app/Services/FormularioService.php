<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Salud;
use App\Models\Educacion;
use App\Models\Infraestructura;
use App\Models\ServicioBasico;
use App\Models\SectorPecuario;
use App\Models\SectorAgricola;
use App\Models\AreaForestal;
use App\Models\FaunaSilvestre;
use App\Models\Asistencia;
use App\Models\Incendio;
use App\Models\Reforestacion;
use App\Models\ReporteComunitario;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;

class FormularioService
{
    public function guardarTodo(int $formularioId, Request $request): void
    {
        // $this->guardarIncendio($formularioId, $request);
        // $this->guardarReporteComunitario($formularioId, $request);
    }

    public function guardarIncendio(Request $request): Incendio
    {
        // 1. Crear ubicación NUEVA para el incendio (solo si el usuario envía algo)
        $ubicacion = null;

        if ($request->filled('direccion_manual') || ($request->filled('lat') && $request->filled('lon'))) {
            $ubicacion = Ubicacion::create([
                'direccion' => $request->input('direccion_manual'),
                'referencia' => $request->input('direccion_manual'),
                'coordenadas' => ($request->has('lat') && $request->has('lon') && is_numeric($request->lat) && is_numeric($request->lon))
                    ? DB::raw("ST_GeomFromText('POINT({$request->lon} {$request->lat})', 4326)")
                    : null,
            ]);
        }

        // Generar código único si no viene
        $codigo = $request->input('codigo_incendio');
        if (empty($codigo)) {
            do {
                $codigo = 'INC-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            } while (Incendio::withTrashed()->where('codigo_incendio', $codigo)->exists());
        }

        // $point = "ST_GeomFromText('POINT({$request->lon} {$request->lat})', 4326)";
        // logger()->info('SQL a ejecutar', ['coordenadas' => $point]);

        // $ubicacion = Ubicacion::create([
        //     'direccion'  => $request->input('direccion_manual'),
        //     'referencia' => $request->input('direccion_manual'),
        //     'coordenadas'=> DB::raw($point),
        // ]);

        return Incendio::create([
            'codigo_incendio' => $codigo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'causas_probables' => $request->causas_probables,
            'estado' => $request->incendio_estado,
            'nivel_gravedad' => $request->nivel_gravedad,
            'area_afectada_ha' => $request->area_afectada_ha,
            'ubicacion_id' => $ubicacion?->id,
            'observaciones' => $request->observaciones,
        ]);
    }

    // public function guardarReporteComunitario(int $formularioId, Request $request): void
    // {
    //     if (
    //         blank($request->incendios_registrados) &&
    //         blank($request->incendios_activos) &&
    //         blank($request->necesidades)
    //     ) return;

    //     ReporteComunitario::create([
    //         'formulario_id' => $formularioId,
    //         'incendios_registrados' => $request->incendios_registrados,
    //         'incendios_activos' => $request->incendios_activos,
    //         'necesidades' => $request->necesidades,
    //         'ayuda_recibida' => $request->ayuda_recibida,
    //         'num_familias_afectadas' => $request->num_familias_afectadas,
    //         'num_familias_damnificadas' => $request->num_familias_damnificadas,
    //         'num_personas_evacuadas' => $request->num_personas_evacuadas,
    //         'vias_acceso_afectadas' => $request->vias_acceso_afectadas,
    //     ]);
    // }
}
