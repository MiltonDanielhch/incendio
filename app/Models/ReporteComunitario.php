<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReporteComunitario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reportes_comunitarios';

    protected $fillable = [
        'formulario_id',
        'incendios_registrados',
        'incendios_activos',
        'necesidades',
        'ayuda_recibida',
        'num_familias_afectadas',
        'num_familias_damnificadas',
        'num_personas_evacuadas',
        'vias_acceso_afectadas'
    ];

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
     * Obtener el municipio a través del formulario y comunidad
     */
    public function municipio()
    {
        return $this->formulario->comunidad->municipio();
    }

    /**
     * Obtener la provincia a través del formulario, comunidad y municipio
     */
    public function provincia()
    {
        return $this->formulario->comunidad->municipio->provincia();
    }

    /**
     * Calcular el total de personas afectadas (suma de familias afectadas * factor promedio)
     */
    public function getTotalPersonasAfectadasAttribute()
    {
        // Suponiendo un promedio de 4 personas por familia
        return $this->num_familias_afectadas * 4;
    }

    /**
     * Calcular el total de personas damnificadas (suma de familias damnificadas * factor promedio)
     */
    public function getTotalPersonasDamnificadasAttribute()
    {
        // Suponiendo un promedio de 4 personas por familia
        return $this->num_familias_damnificadas * 4;
    }

}
