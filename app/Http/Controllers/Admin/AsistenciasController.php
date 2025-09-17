<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Catalogo;
use App\Models\Asistencia;

class AsistenciasController extends Controller
{
    public function editAdd(Formulario $formulario)
    {
        $tipos = Catalogo::where('tipo', 'tipo_asistencia')->get();
        return view('vendor.voyager.formularios.secciones.asistencias.edit-add', compact('formulario', 'tipos'));
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
        Asistencia::updateOrCreate(
            ['formulario_id' => $formulario->id],
            $request->only([
                'tipo_asistencia_id',
                'actividades',
                'cantidad_beneficiarios',
                'fecha_asistencia',
                'organizacion_proveedora',
                'valor_asistencia',
            ]) + ['formulario_id' => $formulario->id]
        );

        return redirect()->route('formularios.ver', $formulario)
                         ->with('success', 'Asistencia guardada.');
    }
}
