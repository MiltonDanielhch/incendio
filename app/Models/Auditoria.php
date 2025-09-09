<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auditoria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auditorias';

    protected $fillable = [
        'tabla_afectada',
        'operacion',
        'valores_anteriores',
        'valores_nuevos',
        'usuario',
        'fecha_operacion',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_nuevos' => 'array',
        'fecha_operacion' => 'datetime',
    ];

    /**
     * Scope para operaciones de creación
     */
    public function scopeCreaciones($query)
    {
        return $query->where('operacion', 'create');
    }

    /**
     * Scope para operaciones de actualización
     */
    public function scopeActualizaciones($query)
    {
        return $query->where('operacion', 'update');
    }

    /**
     * Scope para operaciones de eliminación
     */
    public function scopeEliminaciones($query)
    {
        return $query->where('operacion', 'delete');
    }

    /**
     * Scope para auditorías de una tabla específica
     */
    public function scopePorTabla($query, $tabla)
    {
        return $query->where('tabla_afectada', $tabla);
    }

    /**
     * Scope para auditorías de un usuario específico
     */
    public function scopePorUsuario($query, $usuario)
    {
        return $query->where('usuario', $usuario);
    }

    /**
     * Scope para auditorías recientes (últimos 30 días)
     */
    public function scopeRecientes($query)
    {
        return $query->where('fecha_operacion', '>=', now()->subDays(30));
    }

    /**
     * Obtener los cambios entre valores anteriores y nuevos
     */
    public function getCambiosAttribute()
    {
        if ($this->operacion === 'update' && $this->valores_anteriores && $this->valores_nuevos) {
            $cambios = [];

            foreach ($this->valores_nuevos as $key => $nuevoValor) {
                if (array_key_exists($key, $this->valores_anteriores)) {
                    $valorAnterior = $this->valores_anteriores[$key];

                    if ($valorAnterior != $nuevoValor) {
                        $cambios[$key] = [
                            'anterior' => $valorAnterior,
                            'nuevo' => $nuevoValor
                        ];
                    }
                }
            }

            return $cambios;
        }

        return [];
    }

    /**
     * Verificar si la auditoría tiene cambios significativos
     */
    public function getTieneCambiosSignificativosAttribute()
    {
        return !empty($this->cambios);
    }

    /**
     * Obtener la descripción de la operación en español
     */
    public function getOperacionEspanolAttribute()
    {
        $traducciones = [
            'create' => 'Creación',
            'update' => 'Actualización',
            'delete' => 'Eliminación'
        ];

        return $traducciones[$this->operacion] ?? $this->operacion;
    }
}
