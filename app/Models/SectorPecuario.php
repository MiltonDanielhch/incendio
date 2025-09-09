<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectorPecuario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sectores_pecuarios';

    protected $fillable = [
        'catalogo_id',
        'numero_animales_afectados',
        'numero_animales_fallecidos',
        'numero_animales_evacuados',
        'valor_estimado_perdida',
        'formulario_id'
    ];

    /**
     * Relación con el modelo Catalogo (tipo de especie)
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
     * Calcular el total de animales involucrados
     */
    public function getTotalAnimalesAttribute()
    {
        return $this->numero_animales_afectados +
               $this->numero_animales_fallecidos +
               $this->numero_animales_evacuados;
    }

    /**
     * Calcular el porcentaje de animales fallecidos
     */
    public function getPorcentajeFallecidosAttribute()
    {
        if ($this->total_animales > 0) {
            return ($this->numero_animales_fallecidos / $this->total_animales) * 100;
        }

        return 0;
    }

    /**
     * Calcular el porcentaje de animales evacuados
     */
    public function getPorcentajeEvacuadosAttribute()
    {
        if ($this->total_animales > 0) {
            return ($this->numero_animales_evacuados / $this->total_animales) * 100;
        }

        return 0;
    }

    /**
     * Calcular el valor promedio de pérdida por animal
     */
    public function getValorPromedioPerdidaAttribute()
    {
        if ($this->numero_animales_fallecidos > 0) {
            return $this->valor_estimado_perdida / $this->numero_animales_fallecidos;
        }

        return 0;
    }

    /**
     * Scope para especies con alta mortalidad (>30%)
     */
    public function scopeAltaMortalidad($query)
    {
        return $query->whereRaw('numero_animales_fallecidos / (numero_animales_afectados + numero_animales_fallecidos + numero_animales_evacuados) > 0.3');
    }

    /**
     * Scope para especies con alto valor de pérdida
     */
    public function scopeAltoValorPerdida($query, $valor = 5000)
    {
        return $query->where('valor_estimado_perdida', '>=', $valor);
    }
}
