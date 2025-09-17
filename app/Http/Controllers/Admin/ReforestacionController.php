<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Catalogo;
use App\Models\Reforestacion;

class ReforestacionController extends Controller
{
    public function editAdd(Formulario $formulario)
    {
        $especies = Catalogo::where('tipo', 'especie_forestal')->get();
        return view('vendor.voyager.formularios.secciones.reforestaciones.edit-add', compact('formulario', 'especies'));
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
        Reforestacion::updateOrCreate(
            ['formulario_id' => $formulario->id],
            $request->only([
                'catalogo_id',
                'cantidad_plantines',
                'area_reforestada_ha',
                'fecha_reforestacion',
                'supervivencia_estimada_porcentaje',
            ]) + ['formulario_id' => $formulario->id]
        );

        return redirect()->route('formularios.ver', $formulario) // ← faltaba $formulario
                         ->with('success', 'Reforestación guardada.');
    }
}
