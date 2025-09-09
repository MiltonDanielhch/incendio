<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infraestructura extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'infraestructuras';

    protected $fillable = [
        'catalogo_id',
        'cantidad_afectadas',
        'cantidad_destruidas',
        'valor_estimado_perdida',
        'descripcion_dano',
        'formulario_id'
    ];

    /**
     * Relación con el modelo Catalogo (tipo de infraestructura)
     */
    public function tipoInfraestructura()
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
     * Calcular el total de infraestructuras (afectadas + destruidas)
     */
    public function getTotalInfraestructurasAttribute()
    {
        return $this->cantidad_afectadas + $this->cantidad_destruidas;
    }

    /**
     * Calcular el porcentaje de destrucción
     */
    public function getPorcentajeDestruccionAttribute()
    {
        if ($this->total_infraestructuras > 0) {
            return ($this->cantidad_destruidas / $this->total_infraestructuras) * 100;
        }

        return 0;
    }

    /**
     * Calcular el valor promedio de pérdida por infraestructura
     */
    public function getValorPromedioPerdidaAttribute()
    {
        if ($this->total_infraestructuras > 0) {
            return $this->valor_estimado_perdida / $this->total_infraestructuras;
        }

        return 0;
    }

    /**
     * Scope para infraestructuras con alto valor de pérdida
     */
    public function scopeAltoValorPerdida($query, $valor = 10000)
    {
        return $query->where('valor_estimado_perdida', '>=', $valor);
    }

    /**
     * Scope para infraestructuras totalmente destruidas
     */
    public function scopeTotalmenteDestruidas($query)
    {
        return $query->where('cantidad_destruidas', '>', 0);
    }
}
