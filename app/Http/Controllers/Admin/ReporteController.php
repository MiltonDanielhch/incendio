<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use App\Models\ReporteComunitario;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function editAdd(Formulario $formulario)
    {
        // hasOne → null o modelo
        return view('vendor.voyager.formularios.secciones.reporte.edit-add', compact('formulario'));
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
        ReporteComunitario::updateOrCreate(
            ['formulario_id' => $formulario->id],
            $request->only([
                'incendios_registrados',
                'incendios_activos',
                'num_familias_afectadas',
                'num_familias_damnificadas',
                'num_personas_evacuadas',
                'necesidades',
                'ayuda_recibida',
                'vias_acceso_afectadas',
            ]) + ['formulario_id' => $formulario->id]
        );

        return redirect()->route('formularios.ver', $formulario)
                         ->with('success', 'Reporte general guardado.');
    }
}
