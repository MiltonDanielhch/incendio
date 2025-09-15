<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormularioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $formularioId = $this->route('formulario'); // o $this->route('id') según tu ruta

        return [
            'codigo_formulario' => 'nullable|unique:formularios,codigo_formulario,' . $formularioId,
            'estado' => 'required|in:borrador,completado,validado,rechazado',
            'fecha_llenado' => 'required|date',
            'nombre_encuestador' => 'nullable|string|max:255',
            'contacto_encuestador' => 'nullable|string|max:255',
            'comunidad_id' => 'required|exists:comunidades,id',

            // Incendio (opcional, pero se valida si se envía)
            'fecha_inicio' => 'required|date|before_or_equal:today',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio|before_or_equal:today',
            'causas_probables' => 'nullable|string',
            'incendio_estado' => 'required|in:activo,controlado,extinguido',
            'nivel_gravedad' => 'required|in:bajo,medio,alto,critico',
            'area_afectada_ha' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',

            // Ubicación (opcional)
            'direccion_manual' => 'nullable|string|max:255',
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'lon' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
