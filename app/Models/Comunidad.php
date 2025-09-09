<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comunidad extends Model
{
    use HasFactory, SoftDeletes;

     protected $table = 'comunidades';

    protected $fillable = [
        'nombre',
        'tipo_comunidad',
        'poblacion_aproximada',
        'municipio_id',
        'ubicacion_id'
    ];

    protected $casts = [
        'tipo_comunidad' => 'string',
    ];

    /**
     * Relación con el modelo Municipio
     */
    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

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
     * Relación indirecta con incendios a través de formularios
     */
    public function incendios()
    {
        return $this->hasManyThrough(Incendio::class, Formulario::class);
    }

    /**
     * Obtener la provincia a través del municipio
     */
    public function provincia()
    {
        return $this->municipio->provincia();
    }
}
