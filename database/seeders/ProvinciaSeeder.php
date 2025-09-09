<?php

namespace Database\Seeders;

use App\Models\Provincia;
use App\Models\Ubicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provincias = [
            [
                'nombre' => 'Cercado',
                'codigo' => 'CER',
                'ubicacion' => [
                    'latitud' => -14.8333,
                    'longitud' => -64.9167,
                    'direccion' => 'Provincia Cercado',
                    'referencia' => 'Capital Trinidad'
                ]
            ],
            [
                'nombre' => 'Yacuma',
                'codigo' => 'YAC',
                'ubicacion' => [
                    'latitud' => -13.5000,
                    'longitud' => -65.5000,
                    'direccion' => 'Provincia Yacuma',
                    'referencia' => 'Capital Santa Ana del Yacuma'
                ]
            ],
            [
                'nombre' => 'Moxos',
                'codigo' => 'MOX',
                'ubicacion' => [
                    'latitud' => -15.0833,
                    'longitud' => -65.7500,
                    'direccion' => 'Provincia Moxos',
                    'referencia' => 'Capital San Ignacio de Moxos'
                ]
            ],
            [
                'nombre' => 'Ballivián',
                'codigo' => 'BAL',
                'ubicacion' => [
                    'latitud' => -14.5000,
                    'longitud' => -66.5000,
                    'direccion' => 'Provincia Ballivián',
                    'referencia' => 'Capital Santos Mercado'
                ]
            ],
            [
                'nombre' => 'Marbán',
                'codigo' => 'MAR',
                'ubicacion' => [
                    'latitud' => -15.6667,
                    'longitud' => -64.3333,
                    'direccion' => 'Provincia Marbán',
                    'referencia' => 'Capital Loreto'
                ]
            ],
            [
                'nombre' => 'Iténez',
                'codigo' => 'ITE',
                'ubicacion' => [
                    'latitud' => -13.6667,
                    'longitud' => -63.6667,
                    'direccion' => 'Provincia Iténez',
                    'referencia' => 'Capital Magdalena'
                ]
            ],
            [
                'nombre' => 'Vaca Díez',
                'codigo' => 'VAC',
                'ubicacion' => [
                    'latitud' => -11.0167,
                    'longitud' => -66.0667,
                    'direccion' => 'Provincia Vaca Díez',
                    'referencia' => 'Capital Riberalta'
                ]
            ],
            [
                'nombre' => 'Mamoré',
                'codigo' => 'MAM',
                'ubicacion' => [
                    'latitud' => -13.0000,
                    'longitud' => -64.7500,
                    'direccion' => 'Provincia Mamoré',
                    'referencia' => 'Capital San Joaquín'
                ]
            ],
        ];

        foreach ($provincias as $provinciaData) {
            // Usar el constructor de consultas para insertar la ubicación y obtener el ID
            $ubicacionId = DB::table('ubicaciones')->insertGetId([
                // 'latitud' => $provinciaData['ubicacion']['latitud'],
                // 'longitud' => $provinciaData['ubicacion']['longitud'],
                'direccion' => $provinciaData['ubicacion']['direccion'],
                'referencia' => $provinciaData['ubicacion']['referencia'],
                // 'coordenadas' => DB::raw("ST_PointFromText('POINT({$provinciaData['ubicacion']['longitud']} {$provinciaData['ubicacion']['latitud']})', 4326)"),
                'coordenadas' => DB::raw("ST_GeomFromText('POINT(" . $provinciaData['ubicacion']['longitud'] . " " . $provinciaData['ubicacion']['latitud'] . ")', 4326)"),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Crear la provincia usando el ID de la ubicación
            Provincia::create([
                'nombre' => $provinciaData['nombre'],
                'codigo' => $provinciaData['codigo'],
                'ubicacion_id' => $ubicacionId
            ]);
        }

        $this->command->info('Provincias y sus ubicaciones creadas exitosamente.');
    }
}
