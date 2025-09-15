<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormularioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Incendio (nuevo o existente)
            'codigo_incendio' => 'nullable|string|max:50|unique:incendios,codigo_incendio',
            'fecha_inicio' => 'required|date|before_or_equal:today',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio|before_or_equal:today',
            'causas_probables' => 'nullable|string',
            'incendio_estado' => 'required|in:activo,controlado,extinguido',
            'nivel_gravedad' => 'required|in:bajo,medio,alto,critico',
            'area_afectada_ha' => 'nullable|numeric|min:0',
            'ubicacion_id' => 'nullable|exists:ubicaciones,id',
            'observaciones' => 'nullable|string',

            // Formulario
            'codigo_formulario' => 'nullable|unique:formularios',
            'estado' => 'required|in:borrador,completado,validado,rechazado',
            'fecha_llenado' => 'required|date',
            'nombre_encuestador' => 'nullable|string|max:255',
            'contacto_encuestador' => 'nullable|string|max:255',
            'comunidad_id' => 'required|exists:comunidades,id',
            'municipio_id' => 'required|exists:municipios,id',
            'provincia_id' => 'required|exists:provincias,id',
            // 'incendio_id' => 'required|exists:incendios,id',

            // Reporte comunitario
            'incendios_registrados' => 'nullable|integer',
            'incendios_activos' => 'nullable|integer',
            'necesidades' => 'nullable|string',
            'ayuda_recibida' => 'nullable|string',
            'num_familias_afectadas' => 'nullable|integer',
            'num_familias_damnificadas' => 'nullable|integer',
            'num_personas_evacuadas' => 'nullable|integer',
            'vias_acceso_afectadas' => 'nullable|string',

            // Asistencia
            'actividades' => 'nullable|string',
            'cantidad_beneficiarios' => 'nullable|integer',
            'fecha_asistencia' => 'nullable|date',
            'organizacion_proveedora' => 'nullable|string',
            'tipo_asistencia_id' => 'nullable|exists:catalogos,id',
            'valor_asistencia' => 'nullable|numeric',
        ];
    }
}
