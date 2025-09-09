<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaForestal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'areas_forestales';

    protected $fillable = [
        'catalogo_id',
        'ha_perdidas',
        'ha_afectadas',
        'valor_estimado_perdida',
        'tiempo_recuperacion_estimado_anos',
        'formulario_id'
    ];

    /**
     * Relación con el modelo Catalogo (tipo de área forestal)
     */
    public function tipoAreaForestal()
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
     * Calcular el total de hectáreas impactadas
     */
    public function getTotalHectareasAttribute()
    {
        return $this->ha_afectadas + $this->ha_perdidas;
    }

    /**
     * Calcular el porcentaje de pérdida forestal
     */
    public function getPorcentajePerdidaAttribute()
    {
        if ($this->total_hectareas > 0) {
            return ($this->ha_perdidas / $this->total_hectareas) * 100;
        }

        return 0;
    }

    /**
     * Calcular el valor de pérdida por hectárea
     */
    public function getValorPerdidaPorHectareaAttribute()
    {
        if ($this->total_hectareas > 0) {
            return $this->valor_estimado_perdida / $this->total_hectareas;
        }

        return 0;
    }

    /**
     * Calcular el impacto ecológico (pérdida por año de recuperación)
     */
    public function getImpactoEcologicoAttribute()
    {
        if ($this->tiempo_recuperacion_estimado_anos > 0) {
            return $this->valor_estimado_perdida / $this->tiempo_recuperacion_estimado_anos;
        }

        return $this->valor_estimado_perdida;
    }

    /**
     * Scope para áreas con alto tiempo de recuperación
     */
    public function scopeLargaRecuperacion($query, $anos = 10)
    {
        return $query->where('tiempo_recuperacion_estimado_anos', '>=', $anos);
    }

    /**
     * Scope para áreas con alta pérdida de hectáreas
     */
    public function scopeGranPerdida($query, $hectareas = 100)
    {
        return $query->where('ha_perdidas', '>=', $hectareas);
    }

    /**
     * Scope para tipos específicos de áreas forestales
     */
    public function scopePorTipo($query, $catalogoId)
    {
        return $query->where('catalogo_id', $catalogoId);
    }
}
