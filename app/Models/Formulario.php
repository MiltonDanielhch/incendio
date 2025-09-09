<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formulario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'formularios';

    protected $fillable = [
        'codigo_formulario',
        'estado',
        'fecha_llenado',
        'nombre_encuestador',
        'contacto_encuestador',
        'comunidad_id',
        'incendio_id'
    ];

    protected $casts = [
        'fecha_llenado' => 'date',
        'estado' => 'string',
    ];

    /**
     * Relación con el modelo Comunidad
     */
    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class);
    }

    /**
     * Relación con el modelo Incendio
     */
    public function incendio()
    {
        return $this->belongsTo(Incendio::class);
    }

    /**
     * Relación con el modelo ReporteComunitario
     */
    public function reporteComunitario()
    {
        return $this->hasOne(ReporteComunitario::class);
    }

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
     * Relación con el modelo Educacion
     */
    public function educaciones()
    {
        return $this->hasMany(Educacion::class);
    }

    /**
     * Relación con el modelo Infraestructura
     */
    public function infraestructuras()
    {
        return $this->hasMany(Infraestructura::class);
    }

    /**
     * Relación con el modelo ServicioBasico
     */
    public function serviciosBasicos()
    {
        return $this->hasMany(ServicioBasico::class);
    }

    /**
     * Relación con el modelo SectorPecuario
     */
    public function sectoresPecuarios()
    {
        return $this->hasMany(SectorPecuario::class);
    }

    /**
     * Relación con el modelo SectorAgricola
     */
    public function sectoresAgricolas()
    {
        return $this->hasMany(SectorAgricola::class);
    }

    /**
     * Relación con el modelo AreaForestal
     */
    public function areasForestales()
    {
        return $this->hasMany(AreaForestal::class);
    }

    /**
     * Relación con el modelo FaunaSilvestre
     */
    public function faunaSilvestre()
    {
        return $this->hasMany(FaunaSilvestre::class);
    }

    /**
     * Relación con el modelo Asistencia
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    /**
     * Relación con el modelo Reforestacion
     */
    public function reforestaciones()
    {
        return $this->hasMany(Reforestacion::class);
    }

    /**
     * Obtener el municipio a través de la comunidad
     */
    public function municipio()
    {
        return $this->comunidad->municipio();
    }

    /**
     * Obtener la provincia a través de la comunidad y municipio
     */
    public function provincia()
    {
        return $this->comunidad->municipio->provincia();
    }

    /**
     * Scope para formularios por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para formularios por fecha
     */
    public function scopePorFecha($query, $fecha)
    {
        return $query->where('fecha_llenado', $fecha);
    }
}
