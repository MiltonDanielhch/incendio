<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalogo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogos';

    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion',
        'contexto',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    /**
     * Relación con el modelo Salud (enfermedades/condiciones)
     */
    public function saludEnfermedades()
    {
        return $this->hasMany(Salud::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo Educacion (instituciones educativas)
     */
    public function educacionInstituciones()
    {
        return $this->hasMany(Educacion::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo Infraestructura (tipos de infraestructura)
     */
    public function infraestructuras()
    {
        return $this->hasMany(Infraestructura::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo ServicioBasico (tipos de servicios básicos)
     */
    public function serviciosBasicos()
    {
        return $this->hasMany(ServicioBasico::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo SectorPecuario (tipos de especies)
     */
    public function sectoresPecuarios()
    {
        return $this->hasMany(SectorPecuario::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo SectorAgricola (tipos de cultivos)
     */
    public function sectoresAgricolas()
    {
        return $this->hasMany(SectorAgricola::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo AreaForestal (tipos de áreas forestales)
     */
    public function areasForestales()
    {
        return $this->hasMany(AreaForestal::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo FaunaSilvestre (tipos de fauna/especies)
     */
    public function faunaSilvestre()
    {
        return $this->hasMany(FaunaSilvestre::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo Reforestacion (especies de plantines)
     */
    public function reforestaciones()
    {
        return $this->hasMany(Reforestacion::class, 'catalogo_id');
    }

    /**
     * Relación con el modelo Asistencia (tipos de asistencia)
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'tipo_asistencia_id');
    }
}
