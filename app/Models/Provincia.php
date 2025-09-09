<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provincia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'provincias';

    protected $fillable = [
        'nombre',
        'codigo',
        'ubicacion_id'
    ];

     /**
     * Relación con el modelo Ubicacion
     */
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    /**
     * Relación con el modelo Municipio
     */
    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }

    /**
     * Relación indirecta con comunidades a través de municipios
     */
    public function comunidades()
    {
        return $this->hasManyThrough(Comunidad::class, Municipio::class);
    }

    /**
     * Relación indirecta con incendios a través de municipios y comunidades
     */
    public function incendios()
    {
        return $this->hasManyThrough(Incendio::class, Municipio::class);
    }
}
