<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Catalogo;

use App\Models\SectorAgricola;
use App\Models\SectorPecuario;
use App\Models\AreaForestal;

class EconomicoController extends Controller
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
        $cultivos = Catalogo::where('tipo', 'tipo_cultivo')->get();
        $especies = Catalogo::where('tipo', 'tipo_especie')->get();
        $areas    = Catalogo::where('tipo', 'detalle_area_forestal')->get();

        return view('vendor.voyager.formularios.secciones.economico.edit-add', compact(
            'formulario', 'cultivos', 'especies', 'areas'
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
        // DEBUG: ver qué llega del formulario
        // \Log::debug('FORESTAL input', [$request->input('forestal')]);
        // \Log::debug('FORESTAL input', [$request->all()]);
        // dd($request->all(), $request->input('forestal'));
        // Agricultura
        if ($request->filled('agricola.catalogo_id')) {
            SectorAgricola::updateOrCreate(
                ['formulario_id' => $formulario->id],
                $request->input('agricola') + ['formulario_id' => $formulario->id]
            );
        } else {
            SectorAgricola::where('formulario_id', $formulario->id)->delete();
        }

        // Pecuario
        if ($request->filled('pecuario.catalogo_id')) {
            SectorPecuario::updateOrCreate(
                ['formulario_id' => $formulario->id],
                $request->input('pecuario') + ['formulario_id' => $formulario->id]
            );
        } else {
            SectorPecuario::where('formulario_id', $formulario->id)->delete();
        }

        // Forestal
        if ($request->filled('forestal.catalogo_id')) {
            AreaForestal::updateOrCreate(
                ['formulario_id' => $formulario->id],
                $request->input('forestal') + ['formulario_id' => $formulario->id]
            );
        } else {
            AreaForestal::where('formulario_id', $formulario->id)->delete();
        }

        return redirect()->route('formularios.ver', $formulario)
                        ->with('success', 'Datos económicos guardados.');
    }

    public function matrizRapido(Formulario $formulario, Request $request)
    {
        $request->validate(['filas' => 'required|array']);

        // ---------- AGRÍCOLA (clave = ID del cultivo) ----------
        foreach ($request->input('filas', []) as $clave => $datos) {
            if (!is_numeric($clave)) continue; // solo IDs numéricos

            // Determinamos si es agrícola por el contexto (no empieza con pecuario ni forestal)
            if (empty($datos['catalogo_id']) && empty($datos['ha_afectadas']) && empty($datos['ha_perdidas']) && empty($datos['produccion_estimada_kg']) && empty($datos['valor_estimado_perdida'])) {
                SectorAgricola::where('formulario_id', $formulario->id)
                            ->where('catalogo_id', $clave)
                            ->delete();
            } else {
                SectorAgricola::updateOrCreate(
                    ['formulario_id' => $formulario->id, 'catalogo_id' => $clave],
                    $datos + ['formulario_id' => $formulario->id, 'catalogo_id' => $clave]
                );
            }
        }

        // ---------- PECUARIO (clave = ID de la especie) ----------
        foreach ($request->input('filas', []) as $clave => $datos) {
            if (!is_numeric($clave)) continue;

            if (empty($datos['catalogo_id']) && empty($datos['numero_animales_afectados']) && empty($datos['numero_animales_fallecidos']) && empty($datos['numero_animales_evacuados']) && empty($datos['valor_estimado_perdida'])) {
                SectorPecuario::where('formulario_id', $formulario->id)
                            ->where('catalogo_id', $clave)
                            ->delete();
            } else {
                SectorPecuario::updateOrCreate(
                    ['formulario_id' => $formulario->id, 'catalogo_id' => $clave],
                    $datos + ['formulario_id' => $formulario->id, 'catalogo_id' => $clave]
                );
            }
        }

        // ---------- FORESTAL (clave = ID del tipo de área) ----------
        foreach ($request->input('filas', []) as $clave => $datos) {
            if (!is_numeric($clave)) continue;

            if (empty($datos['catalogo_id']) && empty($datos['ha_afectadas']) && empty($datos['ha_perdidas']) && empty($datos['tiempo_recuperacion_estimado_anos']) && empty($datos['valor_estimado_perdida'])) {
                AreaForestal::where('formulario_id', $formulario->id)
                            ->where('catalogo_id', $clave)
                            ->delete();
            } else {
                AreaForestal::updateOrCreate(
                    ['formulario_id' => $formulario->id, 'catalogo_id' => $clave],
                    $datos + ['formulario_id' => $formulario->id, 'catalogo_id' => $clave]
                );
            }
        }

        return redirect()->route('formularios.ver', $formulario)
                        ->with('success', 'Matriz económica actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
