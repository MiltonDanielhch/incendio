<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incendio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'incendios';

    protected $fillable = [
        'codigo_incendio',
        'fecha_inicio',
        'fecha_fin',
        'causas_probables',
        'estado',
        'nivel_gravedad',
        'area_afectada_ha',
        'ubicacion_id',
        'observaciones'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'estado' => 'string',
        'nivel_gravedad' => 'string',
    ];

    /**
     * Relación con el modelo Ubicacion
     */
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    /**
     * Relación con el modelo Formulario
     */
    public function formularios()
    {
        return $this->hasMany(Formulario::class);
    }

    /**
     * Relación indirecta con comunidades a través de formularios
     */
    public function comunidades()
    {
        return $this->hasManyThrough(Comunidad::class, Formulario::class);
    }

    /**
     * Relación indirecta con municipios a través de comunidades y formularios
     */
    public function municipios()
    {
        return $this->hasManyThrough(Municipio::class, Formulario::class, 'incendio_id', 'id', 'id', 'comunidad_id');
    }

    /**
     * Relación indirecta con provincias a través de municipios, comunidades y formularios
     */
    public function provincias()
    {
        return $this->hasManyThrough(Provincia::class, Formulario::class, 'incendio_id', 'id', 'id', 'comunidad_id');
    }

    /**
     * Obtener el tiempo de duración del incendio en días
     */
    public function getDuracionDiasAttribute()
    {
        if ($this->fecha_fin) {
            return $this->fecha_inicio->diffInDays($this->fecha_fin);
        }

        return $this->fecha_inicio->diffInDays(now());
    }

    /**
     * Scope para incendios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para incendios por nivel de gravedad
     */
    public function scopePorGravedad($query, $nivel)
    {
        return $query->where('nivel_gravedad', $nivel);
    }
}
