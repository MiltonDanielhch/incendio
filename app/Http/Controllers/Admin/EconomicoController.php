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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
