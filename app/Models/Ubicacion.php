<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ubicacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ubicaciones';

    protected $fillable = [
        'latitud',
        'longitud',
        'direccion',
        'referencia',
        'coordenadas'
    ];

    // Relación con Provincias
    public function provincia()
    {
        return $this->hasOne(Provincia::class);
    }

    // Relación con Municipios
    public function municipio()
    {
        return $this->hasOne(Municipio::class);
    }

    // Relación con Comunidades
    public function comunidad()
    {
        return $this->hasOne(Comunidad::class);
    }

    // Relación con Incendios
    public function incendio()
    {
        return $this->hasOne(Incendio::class);
    }

    // Método para obtener coordenadas como array
    public function getCoordenadasAttribute($value)
    {
        // Si estás usando MySQL POINT type, necesitarás parsear el valor
        if ($value) {
            // Parsear el formato POINT(lat lng) de MySQL
            preg_match('/POINT\(([^ ]+) ([^ ]+)\)/', $value, $matches);
            if (count($matches) === 3) {
                return [
                    'latitud' => (float) $matches[1],
                    'longitud' => (float) $matches[2]
                ];
            }
        }
        return null;
    }

    // Método para establecer coordenadas
    public function setCoordenadasAttribute($value)
    {
        if ($value instanceof \Illuminate\Database\Query\Expression) {
            $this->attributes['coordenadas'] = $value;
        } elseif (is_array($value) && isset($value['latitud'], $value['longitud'])) {
            $this->attributes['coordenadas'] = \DB::raw("POINT({$value['latitud']}, {$value['longitud']})");
        }
    }
}
