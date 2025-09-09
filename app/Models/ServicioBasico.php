<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioBasico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicios_basicos';

    protected $fillable = [
        'catalogo_id',
        'descripcion_dano',
        'numero_comunidades_afectadas',
        'dias_sin_servicio',
        'alternativas_implementadas',
        'formulario_id'
    ];


    /**
     * Relación con el modelo Catalogo (tipo de servicio básico)
     */
    public function tipoServicio()
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
     * Calcular el impacto en horas sin servicio (suponiendo 24 horas por día)
     */
    public function getHorasSinServicioAttribute()
    {
        return $this->dias_sin_servicio * 24;
    }

    /**
     * Calcular el impacto porcentual en la comunidad
     */
    public function getImpactoComunidadAttribute()
    {
        if ($this->comunidad && $this->comunidad->poblacion_aproximada > 0) {
            return ($this->numero_comunidades_afectadas / $this->comunidad->poblacion_aproximada) * 100;
        }

        return 0;
    }

    /**
     * Scope para servicios con muchos días sin servicio
     */
    public function scopeDiasSinServicio($query, $dias)
    {
        return $query->where('dias_sin_servicio', '>=', $dias);
    }

    /**
     * Scope para servicios que afectan a múltiples comunidades
     */
    public function scopeAfectacionMultiple($query, $numeroComunidades = 2)
    {
        return $query->where('numero_comunidades_afectadas', '>=', $numeroComunidades);
    }

    /**
     * Verificar si tiene alternativas implementadas
     */
    public function tieneAlternativas()
    {
        return !empty($this->alternativas_implementadas);
    }

}
