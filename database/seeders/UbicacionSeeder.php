<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbicacionSeeder extends Seeder
{
    public function run(): void
    {
        // Coordenadas representativas del departamento del Beni (centro aproximado)
        $ubicaciones = [
            [
                'direccion' => 'Departamento del Beni',
                'referencia' => 'Región noreste de Bolivia',
                'longitud' => -65.5,   // Longitud aproximada del centro del Beni
                'latitud' => -14.5     // Latitud aproximada del centro del Beni
            ],
        ];

        $bar = $this->command->getOutput()->createProgressBar(count($ubicaciones));
        $bar->start();

        foreach ($ubicaciones as $u) {
            // Insertar con SRID 4326 (nota: he quitado latitud y longitud si ya no existen en tu tabla)
            DB::table('ubicaciones')->insert([
                'direccion'   => $u['direccion'],
                'referencia'  => $u['referencia'],
                'coordenadas' => DB::raw("ST_GeomFromText('POINT(" . $u['longitud'] . " " . $u['latitud'] . ")', 4326)"),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\nUbicación del departamento del Beni creada exitosamente.");
    }
}
