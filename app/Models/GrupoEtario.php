<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoEtario extends Model
{
    use HasFactory, SoftDeletes;

     protected $table = 'grupos_etarios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'edad_minima',
        'edad_maxima'
    ];

    /**
     * Relación con el modelo AfectadoIncendio
     */
    public function afectadosIncendios()
    {
        return $this->hasMany(AfectadoIncendio::class);
    }

    /**
     * Relación con el modelo Salud
     */
    public function salud()
    {
        return $this->hasMany(Salud::class);
    }

    /**
     * Obtener el rango de edad formateado
     */
    public function getRangoEdadAttribute()
    {
        if ($this->edad_minima && $this->edad_maxima) {
            return "{$this->edad_minima}-{$this->edad_maxima}";
        } elseif ($this->edad_minima) {
            return "{$this->edad_minima}+";
        } else {
            return 'No especificado';
        }
    }

    /**
     * Scope para buscar por rango de edad
     */
    public function scopePorRangoEdad($query, $edadMinima, $edadMaxima = null)
    {
        if ($edadMaxima) {
            return $query->where('edad_minima', '>=', $edadMinima)
                        ->where('edad_maxima', '<=', $edadMaxima);
        }

        return $query->where('edad_minima', '>=', $edadMinima);
    }

    /**
     * Scope para grupos etarios de niños
     */
    public function scopeNinos($query)
    {
        return $query->where('edad_maxima', '<=', 12);
    }

    /**
     * Scope para grupos etarios de adolescentes
     */
    public function scopeAdolescentes($query)
    {
        return $query->where('edad_minima', '>=', 13)
                    ->where('edad_maxima', '<=', 17);
    }

    /**
     * Scope para grupos etarios de adultos
     */
    public function scopeAdultos($query)
    {
        return $query->where('edad_minima', '>=', 18);
    }
}
