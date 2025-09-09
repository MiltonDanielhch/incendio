<?php

namespace Database\Seeders;

use App\Models\Municipio;
use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipios = [
            // Provincia: Cercado
            [
                'nombre' => 'Trinidad',
                'poblacion_total' => 124357,
                'nombre_alcalde' => 'Cristhian Miguel Cámara Arratia',
                'provincia' => 'Cercado',
                'codigo' => 'TRI',
                'area_km2' => 1010.50,
                'ubicacion' => [
                    'latitud' => -14.8333,
                    'longitud' => -64.9167,
                    'direccion' => 'Municipio Trinidad',
                    'referencia' => 'Capital del Departamento del Beni'
                ]
            ],
            [
                'nombre' => 'San Javier',
                'poblacion_total' => 7654,
                'nombre_alcalde' => 'Dany Añez Montalván',
                'provincia' => 'Cercado',
                'codigo' => 'SJ',
                'area_km2' => 520.75,
                'ubicacion' => [
                    'latitud' => -14.6000,
                    'longitud' => -64.8833,
                    'direccion' => 'Municipio San Javier',
                    'referencia' => 'A 14 km de Trinidad'
                ]
            ],

            // Provincia: Yacuma
            [
                'nombre' => 'Santa Ana del Yacuma',
                'poblacion_total' => 18102,
                'nombre_alcalde' => 'Roció Roca Roca',
                'provincia' => 'Yacuma',
                'codigo' => 'SAY',
                'area_km2' => 15620.30,
                'ubicacion' => [
                    'latitud' => -13.5000,
                    'longitud' => -65.5000,
                    'direccion' => 'Municipio Santa Ana del Yacuma',
                    'referencia' => 'Capital de la Provincia Yacuma'
                ]
            ],
            [
                'nombre' => 'Exaltación',
                'poblacion_total' => 7890,
                'nombre_alcalde' => 'Gonzalo Alfonso Hurtado Toro',
                'provincia' => 'Yacuma',
                'codigo' => 'EXA',
                'area_km2' => 12500.45,
                'ubicacion' => [
                    'latitud' => -13.2667,
                    'longitud' => -65.2333,
                    'direccion' => 'Municipio Exaltación',
                    'referencia' => 'A orillas del río Mamoré'
                ]
            ],

            // Provincia: Moxos
            [
                'nombre' => 'San Ignacio de Moxos',
                'poblacion_total' => 21578,
                'nombre_alcalde' => 'Juan Carlos Abularach Suarez',
                'provincia' => 'Moxos',
                'codigo' => 'SIM',
                'area_km2' => 15820.60,
                'ubicacion' => [
                    'latitud' => -15.0833,
                    'longitud' => -65.7500,
                    'direccion' => 'Municipio San Ignacio de Moxos',
                    'referencia' => 'Capital de la Provincia Moxos'
                ]
            ],

            // Provincia: Ballivián
            [
                'nombre' => 'Santos Reyes',
                'poblacion_total' => 11274,
                'nombre_alcalde' => 'Mercedes Molina Vásquez',
                'provincia' => 'Ballivián',
                'codigo' => 'SR',
                'area_km2' => 8750.25,
                'ubicacion' => [
                    'latitud' => -14.7000,
                    'longitud' => -66.8000,
                    'direccion' => 'Municipio Santos Reyes',
                    'referencia' => 'En la Provincia Ballivián'
                ]
            ],
            [
                'nombre' => 'Santa Rosa de Yacuma',
                'poblacion_total' => 10910,
                'nombre_alcalde' => 'Javier Nogales Jaime',
                'provincia' => 'Ballivián',
                'codigo' => 'SRY',
                'area_km2' => 9200.40,
                'ubicacion' => [
                    'latitud' => -13.2833,
                    'longitud' => -65.9333,
                    'direccion' => 'Municipio Santa Rosa de Yacuma',
                    'referencia' => 'En la Provincia Ballivián'
                ]
            ],
            [
                'nombre' => 'San Borja',
                'poblacion_total' => 45562,
                'nombre_alcalde' => 'Walter Ronal Tovias Simón',
                'provincia' => 'Ballivián',
                'codigo' => 'SB',
                'area_km2' => 11200.75,
                'ubicacion' => [
                    'latitud' => -14.8167,
                    'longitud' => -66.8500,
                    'direccion' => 'Municipio San Borja',
                    'referencia' => 'Ciudad importante del Beni'
                ]
            ],
            [
                'nombre' => 'Rurrenabaque',
                'poblacion_total' => 21018,
                'nombre_alcalde' => 'Elías Moreno Vargas',
                'provincia' => 'Ballivián',
                'codigo' => 'RUR',
                'area_km2' => 6800.30,
                'ubicacion' => [
                    'latitud' => -14.4333,
                    'longitud' => -67.5333,
                    'direccion' => 'Municipio Rurrenabaque',
                    'referencia' => 'Puerta de entrada a la Amazonía'
                ]
            ],

            // Provincia: Marbán
            [
                'nombre' => 'Loreto',
                'poblacion_total' => 4263,
                'nombre_alcalde' => 'Yascara Moreno Flores',
                'provincia' => 'Marbán',
                'codigo' => 'LOR',
                'area_km2' => 5600.80,
                'ubicacion' => [
                    'latitud' => -15.6667,
                    'longitud' => -64.3333,
                    'direccion' => 'Municipio Loreto',
                    'referencia' => 'Capital de la Provincia Marbán'
                ]
            ],
            [
                'nombre' => 'San Andrés',
                'poblacion_total' => 15635,
                'nombre_alcalde' => 'Eber Rudy Vásquez Mamani',
                'provincia' => 'Marbán',
                'codigo' => 'SA',
                'area_km2' => 7200.60,
                'ubicacion' => [
                    'latitud' => -15.5833,
                    'longitud' => -64.4167,
                    'direccion' => 'Municipio San Andrés',
                    'referencia' => 'En la Provincia Marbán'
                ]
            ],

            // Provincia: Iténez
            [
                'nombre' => 'Magdalena',
                'poblacion_total' => 12769,
                'nombre_alcalde' => 'Jorge Donny Chávez Suarez',
                'provincia' => 'Iténez',
                'codigo' => 'MAG',
                'area_km2' => 13400.90,
                'ubicacion' => [
                    'latitud' => -13.2667,
                    'longitud' => -64.0500,
                    'direccion' => 'Municipio Magdalena',
                    'referencia' => 'Capital de la Provincia Iténez'
                ]
            ],
            [
                'nombre' => 'Baures',
                'poblacion_total' => 6564,
                'nombre_alcalde' => 'Roberto Eduardo Ayllón Castedo',
                'provincia' => 'Iténez',
                'codigo' => 'BAU',
                'area_km2' => 18900.25,
                'ubicacion' => [
                    'latitud' => -13.5833,
                    'longitud' => -63.5833,
                    'direccion' => 'Municipio Baures',
                    'referencia' => 'En la Provincia Iténez'
                ]
            ],
            [
                'nombre' => 'Huacaraje',
                'poblacion_total' => 4628,
                'nombre_alcalde' => 'Everty Orihuela Mercado',
                'provincia' => 'Iténez',
                'codigo' => 'HUA',
                'area_km2' => 9800.40,
                'ubicacion' => [
                    'latitud' => -13.6667,
                    'longitud' => -63.6667,
                    'direccion' => 'Municipio Huacaraje',
                    'referencia' => 'En la Provincia Iténez'
                ]
            ],

            // Provincia: Vaca Díez
            [
                'nombre' => 'Riberalta',
                'poblacion_total' => 107141,
                'nombre_alcalde' => 'Ciriaco Rodríguez Vásquez',
                'provincia' => 'Vaca Díez',
                'codigo' => 'RIB',
                'area_km2' => 20500.75,
                'ubicacion' => [
                    'latitud' => -11.0167,
                    'longitud' => -66.0667,
                    'direccion' => 'Municipio Riberalta',
                    'referencia' => 'Capital de la Provincia Vaca Díez'
                ]
            ],
            [
                'nombre' => 'Guayaramerín',
                'poblacion_total' => 40759,
                'nombre_alcalde' => 'Ángel Freddy Maimura Reina',
                'provincia' => 'Vaca Díez',
                'codigo' => 'GUY',
                'area_km2' => 12300.60,
                'ubicacion' => [
                    'latitud' => -10.8167,
                    'longitud' => -65.3667,
                    'direccion' => 'Municipio Guayaramerín',
                    'referencia' => 'Frontera con Brasil'
                ]
            ],

            // Provincia: Mamoré
            [
                'nombre' => 'San Joaquín',
                'poblacion_total' => 6851,
                'nombre_alcalde' => 'Carmen Eris Lima Lobo Dorado',
                'provincia' => 'Mamoré',
                'codigo' => 'SJQ',
                'area_km2' => 7800.35,
                'ubicacion' => [
                    'latitud' => -13.0000,
                    'longitud' => -64.7500,
                    'direccion' => 'Municipio San Joaquín',
                    'referencia' => 'Capital de la Provincia Mamoré'
                ]
            ],
            [
                'nombre' => 'San Ramón',
                'poblacion_total' => 5441,
                'nombre_alcalde' => 'German Sánchez Padilla',
                'provincia' => 'Mamoré',
                'codigo' => 'SRM',
                'area_km2' => 6500.20,
                'ubicacion' => [
                    'latitud' => -13.2833,
                    'longitud' => -64.7167,
                    'direccion' => 'Municipio San Ramón',
                    'referencia' => 'En la Provincia Mamoré'
                ]
            ],
            [
                'nombre' => 'Puerto Siles',
                'poblacion_total' => 1095,
                'nombre_alcalde' => 'Darwin Perrogon Rodríguez',
                'provincia' => 'Mamoré',
                'codigo' => 'PS',
                'area_km2' => 4200.15,
                'ubicacion' => [
                    'latitud' => -12.8333,
                    'longitud' => -64.9167,
                    'direccion' => 'Municipio Puerto Siles',
                    'referencia' => 'A orillas del río Mamoré'
                ]
            ],
        ];

$bar = $this->command->getOutput()->createProgressBar(count($municipios));
        $bar->start();

        foreach ($municipios as $municipioData) {
            try {
                // Buscar la provincia por nombre
                $provincia = Provincia::where('nombre', $municipioData['provincia'])->first();

                if (!$provincia) {
                    $this->command->error("Provincia no encontrada: {$municipioData['provincia']}");
                    continue;
                }

                // Insertar la ubicación (sin las columnas latitud y longitud si ya las eliminaste)
                $ubicacionId = DB::table('ubicaciones')->insertGetId([
                    'direccion'   => $municipioData['ubicacion']['direccion'],
                    'referencia'  => $municipioData['ubicacion']['referencia'],
                    // Usar ST_GeomFromText en lugar de ST_PointFromText
                    'coordenadas' => DB::raw("ST_GeomFromText('POINT(" . $municipioData['ubicacion']['longitud'] . " " . $municipioData['ubicacion']['latitud'] . ")', 4326)"),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                // Crear el municipio
                Municipio::create([
                    'nombre' => $municipioData['nombre'],
                    'codigo' => $municipioData['codigo'],
                    'nombre_alcalde' => $municipioData['nombre_alcalde'],
                    'poblacion_total' => $municipioData['poblacion_total'],
                    'area_km2' => $municipioData['area_km2'],
                    'provincia_id' => $provincia->id,
                    'ubicacion_id' => $ubicacionId
                ]);
            } catch (\Exception $e) {
                $this->command->error("Error creando municipio {$municipioData['nombre']}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\nMunicipios y sus ubicaciones creados exitosamente.");
    }
}
