<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salud extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'salud';

    protected $fillable = [
        'grupo_etario_id',
        'catalogo_id',
        'formulario_id',
        'cantidad_enfermos',
        'gravedad_promedio',
        'tratamiento_requerido'
    ];

    /**
     * Relación con el modelo GrupoEtario
     */
    public function grupoEtario()
    {
        return $this->belongsTo(GrupoEtario::class);
    }

    /**
     * Relación con el modelo Catalogo (enfermedad/condición)
     */
    public function enfermedad()
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
     * Calcular la severidad promedio en texto
     */
    public function getSeveridadTextoAttribute()
    {
        $niveles = [
            1 => 'Muy leve',
            2 => 'Leve',
            3 => 'Moderado',
            4 => 'Grave',
            5 => 'Muy grave'
        ];

        return $niveles[$this->gravedad_promedio] ?? 'No especificado';
    }

    /**
     * Scope para filtrar por nivel de gravedad
     */
    public function scopePorGravedad($query, $nivel)
    {
        return $query->where('gravedad_promedio', $nivel);
    }

    /**
     * Scope para enfermedades graves (nivel 4-5)
     */
    public function scopeGraves($query)
    {
        return $query->where('gravedad_promedio', '>=', 4);
    }
}
