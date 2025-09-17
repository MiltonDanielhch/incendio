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
        'coordenadas',
    ];

    /* -----------------------------------------------------------------
     |  RELACIONES
     * -----------------------------------------------------------------*/

    public function provincia()  { return $this->hasOne(Provincia::class); }
    public function municipio()  { return $this->hasOne(Municipio::class); }
    public function comunidad()  { return $this->hasOne(Comunidad::class); }
    public function incendio()   { return $this->hasOne(Incendio::class); }

    /* -----------------------------------------------------------------
     |  ACCESORES / MUTADORES  (MySQL POINT binario)
     * -----------------------------------------------------------------*/

    /**
     * Devuelve [lat, lng] o null.
     * Se basa en ST_AsText para leer el POINT binario.
     */
    public function getLatLngAttribute(): ?array
    {
        $parsed = $this->coordenadas;   // llama al mutador inferior
        if (!$parsed || !isset($parsed['latitud'], $parsed['longitud'])) {
            return null;
        }
        // Descarta punto (0,0)
        if ($parsed['latitud'] == 0 && $parsed['longitud'] == 0) {
            return null;
        }
        return [(float)$parsed['latitud'], (float)$parsed['longitud']];
    }

    /**
     * Parsea POINT binario → ['latitud' => float, 'longitud' => float]
     */
    public function getCoordenadasAttribute($value)
    {
        if (!$value) return null;

        $row = \DB::select("SELECT ST_AsText(coordenadas) AS point FROM ubicaciones WHERE id = ?", [$this->id])[0] ?? null;
        if (!$row) return null;

        preg_match('/POINT\(([^ ]+) ([^ ]+)\)/', $row->point, $m);
        if (count($m) !== 3) return null;

        return [
            'latitud'  => (float)$m[2], // POINT(long lat)
            'longitud' => (float)$m[1],
        ];
    }

    /**
     * Guarda coordenadas desde array ['latitud' => ..., 'longitud' => ...]
     */
    public function setCoordenadasAttribute($value)
    {
        if ($value instanceof \Illuminate\Database\Query\Expression) {
            $this->attributes['coordenadas'] = $value;
        } elseif (is_array($value) && isset($value['latitud'], $value['longitud'])) {
            $this->attributes['coordenadas'] = \DB::raw("POINT({$value['latitud']}, {$value['longitud']})");
        }
    }
}
