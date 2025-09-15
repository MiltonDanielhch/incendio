<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormularioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ignorar el registro actual para la validación única
        $formularioId = $this->route('formulario'); // ← debe coincidir con el nombre del parámetro en la ruta
    return [
            'codigo_formulario' => 'nullable|unique:formularios,codigo_formulario,' . $formularioId,
            'estado' => 'required|in:borrador,completado,validado,rechazado',
            'fecha_llenado' => 'required|date',
            'nombre_encuestador' => 'nullable|string|max:255',
            'contacto_encuestador' => 'nullable|string|max:255',
            'comunidad_id' => 'required|exists:comunidades,id',
            'incendio_id' => 'required|exists:incendios,id',

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
    public function messages(): array
    {
        return [
            'codigo_formulario.unique' => 'El código de formulario ya está en uso.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno de: borrador, completado, validado, rechazado.',
            'fecha_llenado.required' => 'La fecha de llenado es obligatoria.',
            'fecha_llenado.date' => 'La fecha de llenado debe ser una fecha válida.',
            'comunidad_id.required' => 'Debe seleccionar una comunidad.',
            'comunidad_id.exists' => 'La comunidad seleccionada no existe.',
            'incendio_id.required' => 'Debe seleccionar un incendio.',
            'incendio_id.exists' => 'El incendio seleccionado no existe.',
        ];
    }
}
