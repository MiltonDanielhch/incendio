<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Educacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'educacion';

    protected $fillable = [
        'catalogo_id',
        'modalidad_educacion_id',
        'num_estudiantes',
        'num_estudiantes_afectados',
        'dias_clase_perdidos',
        'formulario_id'
    ];

    /**
     * Relación con el modelo Catalogo (institución educativa)
     */
    public function institucion()
    {
        return $this->belongsTo(Catalogo::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo Catalogo (modalidad educativa)
     */
    public function modalidad()
    {
        return $this->belongsTo(Catalogo::class, 'modalidad_educacion_id');
    }

    /**
     * Relación con el modelo Formulario
     */
    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    /**
     * Obtener el incendio a través del formulario
     */
    public function incendio()
    {
        return $this->formulario->incendio();
    }

    /**
     * Obtener la comunidad a través del formulario
     */
    public function comunidad()
    {
        return $this->formulario->comunidad();
    }

    /**
     * Calcular el porcentaje de estudiantes afectados
     */
    public function getPorcentajeAfectadosAttribute()
    {
        if ($this->num_estudiantes > 0) {
            return ($this->num_estudiantes_afectados / $this->num_estudiantes) * 100;
        }

        return 0;
    }

    /**
     * Calcular el total de horas de clase perdidas (suponiendo 6 horas por día)
     */
    public function getHorasClasePerdidasAttribute()
    {
        return $this->dias_clase_perdidos * 6;
    }

    /**
     * Scope para filtrar por modalidad educativa
     */
    public function scopePorModalidad($query, $modalidadId)
    {
        return $query->where('modalidad_educacion_id', $modalidadId);
    }

    /**
     * Scope para instituciones con alta afectación (>50%)
     */
    public function scopeAltaAfectacion($query)
    {
        return $query->whereRaw('num_estudiantes_afectados / num_estudiantes > 0.5');
    }
}
