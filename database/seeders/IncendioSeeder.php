<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IncendioSeeder extends Seeder
{
    public function run(): void
    {
        $incendios = [
            [
                'codigo_incendio' => 'INC-2024-001',
                'fecha_inicio' => '2024-01-15 08:30:00',
                'fecha_fin' => '2024-01-17 18:45:00',
                'causas_probables' => 'Quema agrícola no controlada',
                'estado' => 'extinguido',
                'nivel_gravedad' => 'alto',
                'area_afectada_ha' => 1250.75,
                'ubicacion' => [
                    'latitud' => -14.8333,
                    'longitud' => -64.9167,
                    'direccion' => 'Zona rural de Trinidad',
                    'referencia' => 'Cerca de la comunidad Copacabana'
                ],
                'observaciones' => 'Incendio controlado después de 3 días, afectó pastizales y áreas de cultivo'
            ],
            [
                'codigo_incendio' => 'INC-2024-002',
                'fecha_inicio' => '2024-02-03 14:20:00',
                'fecha_fin' => '2024-02-04 09:15:00',
                'causas_probables' => 'Fogata mal apagada',
                'estado' => 'extinguido',
                'nivel_gravedad' => 'medio',
                'area_afectada_ha' => 350.25,
                'ubicacion' => [
                    'latitud' => -13.5000,
                    'longitud' => -65.5000,
                    'direccion' => 'Área cercana a Santa Ana del Yacuma',
                    'referencia' => 'Cerca del Río Yacuma'
                ],
                'observaciones' => 'Incendio rápido, afectó principalmente matorrales'
            ],
            [
                'codigo_incendio' => 'INC-2024-003',
                'fecha_inicio' => '2024-02-20 11:45:00',
                'fecha_fin' => null,
                'causas_probables' => 'Descarga eléctrica',
                'estado' => 'activo',
                'nivel_gravedad' => 'critico',
                'area_afectada_ha' => 3200.50,
                'ubicacion' => [
                    'latitud' => -15.0833,
                    'longitud' => -65.7500,
                    'direccion' => 'Zona de San Ignacio de Moxos',
                    'referencia' => 'Área forestal protegida'
                ],
                'observaciones' => 'Incendio de grandes proporciones, equipos de bomberos trabajando en el lugar'
            ],
            [
                'codigo_incendio' => 'INC-2024-004',
                'fecha_inicio' => '2024-03-05 09:15:00',
                'fecha_fin' => '2024-03-05 16:30:00',
                'causas_probables' => 'Quema de basura',
                'estado' => 'extinguido',
                'nivel_gravedad' => 'bajo',
                'area_afectada_ha' => 45.80,
                'ubicacion' => [
                    'latitud' => -14.8167,
                    'longitud' => -66.8500,
                    'direccion' => 'Periferia de San Borja',
                    'referencia' => 'Cerca del vertedero municipal'
                ],
                'observaciones' => 'Incendio controlado rápidamente, afectación mínima'
            ],
            [
                'codigo_incendio' => 'INC-2024-005',
                'fecha_inicio' => '2024-03-12 16:40:00',
                'fecha_fin' => '2024-03-14 12:00:00',
                'causas_probables' => 'Rayos durante tormenta eléctrica',
                'estado' => 'controlado',
                'nivel_gravedad' => 'alto',
                'area_afectada_ha' => 1850.30,
                'ubicacion' => [
                    'latitud' => -11.0167,
                    'longitud' => -66.0667,
                    'direccion' => 'Área cercana a Riberalta',
                    'referencia' => 'Zona de bosque seco'
                ],
                'observaciones' => 'Incendio controlado pero persisten focos de calor, monitoreo continuo'
            ],
            [
                'codigo_incendio' => 'INC-2024-006',
                'fecha_inicio' => '2024-03-18 13:10:00',
                'fecha_fin' => null,
                'causas_probables' => 'Desconocida (en investigación)',
                'estado' => 'activo',
                'nivel_gravedad' => 'medio',
                'area_afectada_ha' => 620.40,
                'ubicacion' => [
                    'latitud' => -13.6667,
                    'longitud' => -63.6667,
                    'direccion' => 'Cercanías de Magdalena',
                    'referencia' => 'Área de transición entre sabana y bosque'
                ],
                'observaciones' => 'Equipos de respuesta trabajando en el área, vientos moderados dificultan las labores'
            ],
            [
                'codigo_incendio' => 'INC-2024-007',
                'fecha_inicio' => '2024-03-22 10:05:00',
                'fecha_fin' => '2024-03-22 14:20:00',
                'causas_probables' => 'Trabajos de soldadura',
                'estado' => 'extinguido',
                'nivel_gravedad' => 'bajo',
                'area_afectada_ha' => 15.75,
                'ubicacion' => [
                    'latitud' => -10.8167,
                    'longitud' => -65.3667,
                    'direccion' => 'Zona industrial de Guayaramerín',
                    'referencia' => 'Cerca del puerto'
                ],
                'observaciones' => 'Incendio industrial controlado rápidamente, daños materiales mínimos'
            ]
        ];

   $bar = $this->command->getOutput()->createProgressBar(count($incendios));
        $bar->start();

        foreach ($incendios as $incendioData) {
            try {
                // Insertar la ubicación (sin las columnas latitud y longitud)
                $ubicacionId = DB::table('ubicaciones')->insertGetId([
                    'direccion'   => $incendioData['ubicacion']['direccion'],
                    'referencia'  => $incendioData['ubicacion']['referencia'],
                    'coordenadas' => DB::raw("ST_GeomFromText('POINT(" . $incendioData['ubicacion']['longitud'] . " " . $incendioData['ubicacion']['latitud'] . ")', 4326)"),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                DB::table('incendios')->insert([
                    'codigo_incendio'  => $incendioData['codigo_incendio'],
                    'fecha_inicio'     => $incendioData['fecha_inicio'],
                    'fecha_fin'        => $incendioData['fecha_fin'],
                    'causas_probables' => $incendioData['causas_probables'],
                    'estado'           => $incendioData['estado'],
                    'nivel_gravedad'   => $incendioData['nivel_gravedad'],
                    'area_afectada_ha' => $incendioData['area_afectada_ha'],
                    'ubicacion_id'     => $ubicacionId,
                    'observaciones'    => $incendioData['observaciones'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            } catch (\Exception $e) {
                $this->command->error("Error creando incendio {$incendioData['codigo_incendio']}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\nIncendios creados exitosamente.");
    }
}
