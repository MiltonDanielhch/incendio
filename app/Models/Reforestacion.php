<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reforestacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reforestaciones';

    protected $fillable = [
        'catalogo_id',
        'cantidad_plantines',
        'area_reforestada_ha',
        'fecha_reforestacion',
        'supervivencia_estimada_porcentaje',
        'formulario_id'
    ];

    protected $casts = [
        'fecha_reforestacion' => 'date',
        'supervivencia_estimada_porcentaje' => 'decimal:2',
    ];

    /**
     * Relación con el modelo Catalogo (especie de plantín)
     */
    public function especiePlantin()
    {
        return $this->belongsTo(Catalogo::class, 'catalogo_id');
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
     * Calcular la densidad de plantines por hectárea
     */
    public function getDensidadPlantinesAttribute()
    {
        if ($this->area_reforestada_ha > 0) {
            return $this->cantidad_plantines / $this->area_reforestada_ha;
        }

        return 0;
    }

    /**
     * Calcular la cantidad estimada de plantines que sobrevivirán
     */
    public function getPlantinesSobrevivientesAttribute()
    {
        return $this->cantidad_plantines * ($this->supervivencia_estimada_porcentaje / 100);
    }

    /**
     * Calcular la eficiencia de la reforestación (supervivencia por hectárea)
     */
    public function getEficienciaReforestacionAttribute()
    {
        if ($this->area_reforestada_ha > 0) {
            return $this->plantines_sobrevivientes / $this->area_reforestada_ha;
        }

        return 0;
    }

    /**
     * Verificar si la reforestación es reciente (últimos 6 meses)
     */
    public function getEsRecienteAttribute()
    {
        return $this->fecha_reforestacion->diffInMonths(now()) <= 6;
    }

    /**
     * Scope para reforestaciones con alta supervivencia (>80%)
     */
    public function scopeAltaSupervivencia($query)
    {
        return $query->where('supervivencia_estimada_porcentaje', '>=', 80);
    }

    /**
     * Scope para reforestaciones de grandes áreas (>5 ha)
     */
    public function scopeGranExtension($query)
    {
        return $query->where('area_reforestada_ha', '>=', 5);
    }

    /**
     * Scope para reforestaciones recientes (último año)
     */
    public function scopeRecientes($query)
    {
        return $query->where('fecha_reforestacion', '>=', now()->subYear());
    }

    /**
     * Scope para especies específicas de plantines
     */
    public function scopePorEspecie($query, $catalogoId)
    {
        return $query->where('catalogo_id', $catalogoId);
    }
}
