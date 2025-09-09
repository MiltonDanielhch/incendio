<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaunaSilvestre extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fauna_silvestre';

    protected $fillable = [
        'catalogo_id',
        'cantidad_animales',
        'cantidad_animales_muertos',
        'cantidad_animales_afectados',
        'formulario_id'
    ];

    /**
     * Relación con el modelo Catalogo (tipo de fauna o especie)
     */
    public function especie()
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
     * Calcular el total de animales impactados
     */
    public function getTotalAnimalesImpactadosAttribute()
    {
        return $this->cantidad_animales_muertos + $this->cantidad_animales_afectados;
    }

    /**
     * Calcular el porcentaje de mortalidad
     */
    public function getPorcentajeMortalidadAttribute()
    {
        if ($this->cantidad_animales > 0) {
            return ($this->cantidad_animales_muertos / $this->cantidad_animales) * 100;
        }

        return 0;
    }

    /**
     * Calcular el porcentaje de animales afectados
     */
    public function getPorcentajeAfectadosAttribute()
    {
        if ($this->cantidad_animales > 0) {
            return ($this->cantidad_animales_afectados / $this->cantidad_animales) * 100;
        }

        return 0;
    }

    /**
     * Calcular el impacto total (mortalidad + afectados)
     */
    public function getImpactoTotalAttribute()
    {
        if ($this->cantidad_animales > 0) {
            return (($this->cantidad_animales_muertos + $this->cantidad_animales_afectados) / $this->cantidad_animales) * 100;
        }

        return 0;
    }

    /**
     * Scope para especies con alta mortalidad (>20%)
     */
    public function scopeAltaMortalidad($query)
    {
        return $query->whereRaw('cantidad_animales_muertos / cantidad_animales > 0.2');
    }

    /**
     * Scope para especies con alto impacto (>50%)
     */
    public function scopeAltoImpacto($query)
    {
        return $query->whereRaw('(cantidad_animales_muertos + cantidad_animales_afectados) / cantidad_animales > 0.5');
    }

    /**
     * Scope para especies en peligro (más del 30% de mortalidad)
     */
    public function scopeEspeciesEnPeligro($query)
    {
        return $query->whereRaw('cantidad_animales_muertos / cantidad_animales > 0.3');
    }
}
