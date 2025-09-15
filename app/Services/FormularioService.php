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

    public function actualizarIncendio(Incendio $incendio, Request $request): void
    {
        // Actualizar datos del incendio
        $incendio->update([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'causas_probables' => $request->causas_probables,
            'estado' => $request->incendio_estado,
            'nivel_gravedad' => $request->nivel_gravedad,
            'area_afectada_ha' => $request->area_afectada_ha,
            'observaciones' => $request->observaciones,
        ]);

        // Actualizar o crear ubicación
        if ($request->filled('direccion_manual') || ($request->filled('lat') && $request->filled('lon'))) {
            $ubicacionData = [
                'direccion' => $request->input('direccion_manual'),
                'referencia' => $request->input('direccion_manual'),
                'coordenadas' => ($request->has('lat') && $request->has('lon') && is_numeric($request->lat) && is_numeric($request->lon))
                    ? DB::raw("ST_GeomFromText('POINT({$request->lon} {$request->lat})', 4326)")
                    : null,
            ];

            if ($incendio->ubicacion) {
                $incendio->ubicacion->update($ubicacionData);
            } else {
                $ubicacion = Ubicacion::create($ubicacionData);
                $incendio->update(['ubicacion_id' => $ubicacion->id]);
            }
        }
    }
}
