<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AfectadoIncendio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'afectados_incendios';

    protected $fillable = [
        'grupo_etario_id',
        'cantidad_afectados',
        'cantidad_fallecidos',
        'cantidad_lesionados',
        'formulario_id'
    ];

    /**
     * Relación con el modelo GrupoEtario
     */
    public function grupoEtario()
    {
        return $this->belongsTo(GrupoEtario::class);
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
     * Calcular el total de afectados (afectados + fallecidos + lesionados)
     */
    public function getTotalAfectadosAttribute()
    {
        return $this->cantidad_afectados + $this->cantidad_fallecidos + $this->cantidad_lesionados;
    }

    /**
     * Calcular el porcentaje de fallecidos
     */
    public function getPorcentajeFallecidosAttribute()
    {
        if ($this->total_afectados > 0) {
            return ($this->cantidad_fallecidos / $this->total_afectados) * 100;
        }

        return 0;
    }

    /**
     * Calcular el porcentaje de lesionados
     */
    public function getPorcentajeLesionadosAttribute()
    {
        if ($this->total_afectados > 0) {
            return ($this->cantidad_lesionados / $this->total_afectados) * 100;
        }

        return 0;
    }
}
