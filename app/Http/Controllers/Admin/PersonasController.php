<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogo;
use Illuminate\Http\Request;

use App\Models\Formulario;
use App\Models\GrupoEtario;
use App\Models\AfectadoIncendio;
use App\Models\Salud;


class PersonasController extends Controller
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
        $grupos = GrupoEtario::all();
        $enfermedades = Catalogo::where('tipo', 'enfermedad')->get();
        return view('vendor.voyager.formularios.secciones.personas.edit-add', compact('formulario', 'grupos', 'enfermedades'));
    }

        /**
     * Guardar o actualizar (personas + salud)
     */
    public function store(Formulario $formulario, Request $request)
    {
        return $this->saveData($formulario, $request);
    }

    public function update(Formulario $formulario, Request $request)
    {
        return $this->saveData($formulario, $request);
    }

     /**
     * Guarda ambas tablas en una misma transacción
     */
    private function saveData(Formulario $formulario, Request $request)
    {
        // 1. Personas (afectados_incendios)
        AfectadoIncendio::updateOrCreate(
            ['formulario_id' => $formulario->id, 'grupo_etario_id' => $request->grupo_etario_id],
            [
                'cantidad_afectados'  => $request->cantidad_afectados ?? 0,
                'cantidad_fallecidos' => $request->cantidad_fallecidos ?? 0,
                'cantidad_lesionados' => $request->cantidad_lesionados ?? 0,
            ]
        );

        // 2. Salud (opcional)
        if ($request->filled('salud.catalogo_id')) {
            Salud::updateOrCreate(
                ['formulario_id' => $formulario->id],
                [
                    'grupo_etario_id'        => $request->grupo_etario_id,
                    'catalogo_id'            => $request->input('salud.catalogo_id'),
                    'cantidad_enfermos'      => $request->input('salud.cantidad_enfermos', 0),
                    'gravedad_promedio'      => $request->input('salud.gravedad_promedio'),
                    'tratamiento_requerido'  => $request->input('salud.tratamiento_requerido'),
                ]
            );
        } else {
            // Si eligió "Ninguna", borramos salud para ese formulario
            Salud::where('formulario_id', $formulario->id)->delete();
        }

        return redirect()->route('formularios.ver', $formulario)
                         ->with('success', 'Datos de personas y salud guardados.');
    }

    public function matrizRapido(Formulario $formulario, Request $request)
    {
        // 1) AFECTADOS (grupo por grupo)
        foreach ($request->input('filas', []) as $grupoId => $f) {
            AfectadoIncendio::updateOrCreate(
                ['formulario_id' => $formulario->id, 'grupo_etario_id' => $grupoId],
                [
                    'cantidad_afectados'  => $f['afectados']  ?? 0,
                    'cantidad_lesionados' => $f['lesionados'] ?? 0,
                    'cantidad_fallecidos' => $f['fallecidos'] ?? 0,
                ]
            );
        }

        // ✅ DEBUG: qué está llegando en salud
        $saludInput = $request->input('salud', []);
        // dd('SALUD LLEGANDO', $saludInput);

        // 2) Borrar toda la salud del formulario
        $formulario->salud()->delete();

        // 3) Insertar solo lo que venga
        foreach ($saludInput as $enfId => $porGrupo) {
            foreach ($porGrupo as $grupoId => $campos) {
                if (empty($campos['cantidad_enfermos']) &&
                    empty($campos['gravedad_promedio']) &&
                    empty($campos['tratamiento_requerido'])) {
                    continue;
                }

                Salud::create([
                    'formulario_id'         => $formulario->id,
                    'grupo_etario_id'       => $grupoId,
                    'catalogo_id'           => $enfId,
                    'cantidad_enfermos'     => $campos['cantidad_enfermos'] ?? 0,
                    'gravedad_promedio'     => $campos['gravedad_promedio'] ?? null,
                    'tratamiento_requerido' => $campos['tratamiento_requerido'] ?? null,
                ]);
            }
        }

        return redirect()->route('formularios.ver', $formulario)
            ->with('success', 'Matriz de personas y salud actualizada.');
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
