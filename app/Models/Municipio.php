<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'municipios';

    protected $fillable = [
        'nombre',
        'codigo',
        'nombre_alcalde',
        'poblacion_total',
        'area_km2',
        'provincia_id',
        'ubicacion_id'
    ];

    /**
     * Relación con el modelo Provincia
     */
    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    /**
     * Relación con el modelo Ubicacion
     */
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    /**
     * Relación con el modelo Comunidad
     */
    public function comunidades()
    {
        return $this->hasMany(Comunidad::class);
    }

    /**
     * Relación indirecta con incendios a través de comunidades
     */
    public function incendios()
    {
        return $this->hasManyThrough(Incendio::class, Comunidad::class);
    }

    /**
     * Relación indirecta con formularios a través de comunidades
     */
    public function formularios()
    {
        return $this->hasManyThrough(Formulario::class, Comunidad::class);
    }
}
