<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectorAgricola extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sectores_agricolas';

    protected $fillable = [
        'catalogo_id',
        'ha_afectadas',
        'ha_perdidas',
        'produccion_estimada_kg',
        'valor_estimado_perdida',
        'formulario_id'
    ];

    /**
     * Relación con el modelo Catalogo (tipo de cultivo)
     */
    public function cultivo()
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
     * Calcular el porcentaje de hectáreas perdidas
     */
    public function getPorcentajePerdidaAttribute()
    {
        if ($this->ha_afectadas > 0) {
            return ($this->ha_perdidas / $this->ha_afectadas) * 100;
        }

        return 0;
    }

    /**
     * Calcular la producción estimada por hectárea
     */
    public function getProduccionPorHectareaAttribute()
    {
        if ($this->ha_afectadas > 0) {
            return $this->produccion_estimada_kg / $this->ha_afectadas;
        }

        return 0;
    }

    /**
     * Calcular el valor de pérdida por hectárea
     */
    public function getValorPerdidaPorHectareaAttribute()
    {
        if ($this->ha_perdidas > 0) {
            return $this->valor_estimado_perdida / $this->ha_perdidas;
        }

        return 0;
    }

    /**
     * Calcular la producción total perdida en kg
     */
    public function getProduccionPerdidaKgAttribute()
    {
        if ($this->produccion_por_hectarea > 0) {
            return $this->ha_perdidas * $this->produccion_por_hectarea;
        }

        return 0;
    }

    /**
     * Scope para cultivos con alta afectación (>50% de pérdida)
     */
    public function scopeAltaAfectacion($query)
    {
        return $query->whereRaw('ha_perdidas / ha_afectadas > 0.5');
    }

    /**
     * Scope para cultivos con alto valor de pérdida
     */
    public function scopeAltoValorPerdida($query, $valor = 10000)
    {
        return $query->where('valor_estimado_perdida', '>=', $valor);
    }

    /**
     * Scope para cultivos específicos por tipo
     */
    public function scopePorTipoCultivo($query, $catalogoId)
    {
        return $query->where('catalogo_id', $catalogoId);
    }
}
