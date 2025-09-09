<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asistencias';

    protected $fillable = [
        'actividades',
        'cantidad_beneficiarios',
        'fecha_asistencia',
        'organizacion_proveedora',
        'tipo_asistencia_id',
        'valor_asistencia',
        'formulario_id'
    ];

    protected $casts = [
        'fecha_asistencia' => 'date',
    ];

    /**
     * Relación con el modelo Catalogo (tipo de asistencia)
     */
    public function tipoAsistencia()
    {
        return $this->belongsTo(Catalogo::class, 'tipo_asistencia_id');
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
     * Calcular el valor promedio de asistencia por beneficiario
     */
    public function getValorPorBeneficiarioAttribute()
    {
        if ($this->cantidad_beneficiarios > 0) {
            return $this->valor_asistencia / $this->cantidad_beneficiarios;
        }

        return 0;
    }

    /**
     * Calcular la eficiencia de la asistencia (valor por beneficiario)
     */
    public function getEficienciaAsistenciaAttribute()
    {
        if ($this->valor_por_beneficiario > 0) {
            // Puedes definir tu propia métrica de eficiencia aquí
            return $this->cantidad_beneficiarios / $this->valor_por_beneficiario;
        }

        return 0;
    }

    /**
     * Verificar si la asistencia es reciente (últimos 30 días)
     */
    public function getEsRecienteAttribute()
    {
        return $this->fecha_asistencia->diffInDays(now()) <= 30;
    }

    /**
     * Scope para asistencias de un tipo específico
     */
    public function scopePorTipo($query, $tipoAsistenciaId)
    {
        return $query->where('tipo_asistencia_id', $tipoAsistenciaId);
    }

    /**
     * Scope para asistencias con alto valor
     */
    public function scopeAltoValor($query, $valor = 5000)
    {
        return $query->where('valor_asistencia', '>=', $valor);
    }

    /**
     * Scope para asistencias con muchos beneficiarios
     */
    public function scopeMuchosBeneficiarios($query, $cantidad = 100)
    {
        return $query->where('cantidad_beneficiarios', '>=', $cantidad);
    }

    /**
     * Scope para asistencias recientes
     */
    public function scopeRecientes($query)
    {
        return $query->where('fecha_asistencia', '>=', now()->subDays(30));
    }
}
