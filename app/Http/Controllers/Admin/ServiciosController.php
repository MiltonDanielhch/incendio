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
        $modalidades   = Catalogo::where('tipo', 'modalidad_educacion')->get();

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
