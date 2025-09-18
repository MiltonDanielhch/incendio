<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Formulario;
use App\Models\Catalogo;
use App\Models\Infraestructura;
use App\Models\ServicioBasico;
use App\Models\Educacion;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function editAdd(Formulario $formulario)
    {
        // Cargar las relaciones que vas a usar
        $formulario->load(['infraestructuras', 'serviciosBasicos', 'educaciones']);

        $infraTipos    = Catalogo::where('tipo', 'tipo_infraestructura')->get();
        $servTipos     = Catalogo::where('tipo', 'tipo_servicio')->get();
        $instituciones = Catalogo::where('tipo', 'tipo_infraestructura')
                                 ->where('contexto', 'educacion')
                                 ->get();
        $modalidades = Catalogo::where('tipo', 'modalidad_educacion')->get();


        return view('vendor.voyager.formularios.secciones.servicios.edit-add', compact(
            'formulario', 'infraTipos', 'servTipos', 'instituciones', 'modalidades'
        ));
    }

    public function store(Formulario $formulario, Request $request)
    {
        return $this->saveData($formulario, $request);
    }

    public function update(Formulario $formulario, Request $request)
    {
        return $this->saveData($formulario, $request);
    }

    private function saveData(Formulario $formulario, Request $request)
    {
        // Infraestructura
        if ($request->filled('infra.catalogo_id')) {
            Infraestructura::updateOrCreate(
                ['formulario_id' => $formulario->id],
                $request->input('infra') + ['formulario_id' => $formulario->id]
            );
        } else {
            Infraestructura::where('formulario_id', $formulario->id)->delete();
        }

        // Servicios básicos
        if ($request->filled('servicio.catalogo_id')) {
            ServicioBasico::updateOrCreate(
                ['formulario_id' => $formulario->id],
                $request->input('servicio') + ['formulario_id' => $formulario->id]
            );
        } else {
            ServicioBasico::where('formulario_id', $formulario->id)->delete();
        }

        // Educación
        if ($request->filled('edu.catalogo_id')) {
            Educacion::updateOrCreate(
                ['formulario_id' => $formulario->id],
                $request->input('edu') + ['formulario_id' => $formulario->id]
            );
        } else {
            Educacion::where('formulario_id', $formulario->id)->delete();
        }

        return redirect()->route('formularios.ver', $formulario)
                        ->with('success', 'Servicios e infraestructura guardados.');
    }

    public function matrizRapido(Formulario $formulario, Request $request)
    {
        $request->validate(['filas' => 'required|array']);

        // ---------- INFRAESTRUCTURA (clave = ID del tipo) ----------
        foreach ($request->input('filas', []) as $clave => $datos) {
            if (!is_numeric($clave)) continue;

            // Determinamos si es infraestructura por el contexto (no empieza con servicio ni educacion)
            if (empty($datos['catalogo_id']) && empty($datos['cantidad_afectadas']) && empty($datos['cantidad_destruidas']) && empty($datos['valor_estimado_perdida'])) {
                Infraestructura::where('formulario_id', $formulario->id)
                            ->where('catalogo_id', $clave)
                            ->delete();
            } else {
                Infraestructura::updateOrCreate(
                    ['formulario_id' => $formulario->id, 'catalogo_id' => $clave],
                    $datos + ['formulario_id' => $formulario->id, 'catalogo_id' => $clave]
                );
            }
        }

        // ---------- SERVICIOS BÁSICOS (clave = ID del servicio) ----------
        foreach ($request->input('filas', []) as $clave => $datos) {
            if (!is_numeric($clave)) continue;

            if (empty($datos['catalogo_id']) && empty($datos['numero_comunidades_afectadas']) && empty($datos['dias_sin_servicio']) && empty($datos['valor_estimado_perdida'])) {
                ServicioBasico::where('formulario_id', $formulario->id)
                            ->where('catalogo_id', $clave)
                            ->delete();
            } else {
                ServicioBasico::updateOrCreate(
                    ['formulario_id' => $formulario->id, 'catalogo_id' => $clave],
                    $datos + ['formulario_id' => $formulario->id, 'catalogo_id' => $clave]
                );
            }
        }

        // ---------- EDUCACIÓN (institución → modalidad) ----------
        foreach ($request->input('edu', []) as $instId => $porMod) {
            foreach ($porMod as $modId => $campos) {

                // ✅ Saltar claves no numéricas (como 'catalogo_id')
                if (!is_numeric($modId)) {
                    continue;
                }

                // 1. Si todo está vacío → borramos
                if (
                    empty($campos['num_estudiantes']) &&
                    empty($campos['num_estudiantes_afectados']) &&
                    empty($campos['dias_clase_perdidos'])
                ) {
                    Educacion::where('formulario_id', $formulario->id)
                            ->where('catalogo_id', $instId)
                            ->where('modalidad_educacion_id', $modId)
                            ->delete();
                    continue;
                }

                // 2. Solo los campos que necesitamos
                $data = [
                    'num_estudiantes'           => $campos['num_estudiantes'] ?? 0,
                    'num_estudiantes_afectados' => $campos['num_estudiantes_afectados'] ?? 0,
                    'dias_clase_perdidos'       => $campos['dias_clase_perdidos'] ?? 0,
                ];

                // 3. Guardar / actualizar
                Educacion::updateOrCreate(
                    [
                        'formulario_id'          => $formulario->id,
                        'catalogo_id'            => $instId,
                        'modalidad_educacion_id' => $modId,
                    ],
                    $data
                );
            }
        }

        return redirect()->route('formularios.ver', $formulario)
                        ->with('success', 'Matriz de servicios e infraestructura actualizada.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
