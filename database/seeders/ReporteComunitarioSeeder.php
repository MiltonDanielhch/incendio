<?php

namespace Database\Seeders;

use App\Models\ReporteComunitario;
use App\Models\Formulario;
use Illuminate\Database\Seeder;

class ReporteComunitarioSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los formularios existentes
        $formularios = Formulario::all();

        if ($formularios->isEmpty()) {
            $this->command->error('Primero debes ejecutar el seeder de Formularios.');
            return;
        }

        $necesidadesPosibles = [
            'Agua potable',
            'Alimentos no perecederos',
            'Medicamentos básicos',
            'Víveres de primera necesidad',
            'Ropa y mantas',
            'Materiales de construcción',
            'Asistencia médica',
            'Apoyo psicológico',
            'Albergue temporal',
            'Utensilios de cocina',
            'Herramientas para reconstrucción',
            'Semillas para cultivo',
            'Apoyo con maquinaria pesada',
            'Equipos de comunicación'
        ];

        $ayudasRecibidas = [
            'Donación de alimentos de ONG internacional',
            'Apoyo del gobierno municipal con víveres',
            'Brigadas médicas del Ministerio de Salud',
            'Equipos de bomberos voluntarios',
            'Donación de agua embotellada de empresa local',
            'Campaña de recolección de ropa usada',
            'Apoyo económico de organización benéfica',
            'Voluntarios para limpieza y reconstrucción',
            'Entrega de medicamentos por parte de PSF',
            'Instalación de carpas de albergue por Defensa Civil'
        ];

        $viasAfectadas = [
            'Carretera principal bloqueada por árboles caídos',
            'Camino vecinal inundado',
            'Puente colapsado en acceso principal',
            'Derrumbe en vía de acceso a la comunidad',
            'Camino intransitable por cenizas y residuos',
            'Vías secundarias obstruidas por escombros',
            'Caminos rurales dañados por el fuego',
            'Accesos principales con visibilidad reducida por humo',
            'Vías de evacuación obstruidas',
            'Caminos de herradura desaparecidos por el incendio'
        ];

        $bar = $this->command->getOutput()->createProgressBar(count($formularios));
        $bar->start();

        foreach ($formularios as $formulario) {
            try {
                // Datos aleatorios pero realistas
                $incendiosRegistrados = rand(1, 5);
                $incendiosActivos = rand(0, min(2, $incendiosRegistrados));
                $numFamiliasAfectadas = rand(5, 50);
                $numFamiliasDamnificadas = rand(0, $numFamiliasAfectadas);
                $numPersonasEvacuadas = rand(0, $numFamiliasAfectadas * 4);

                // Seleccionar necesidades aleatorias (entre 1 y 4)
                $necesidadesSeleccionadas = implode(', ', $this->array_random($necesidadesPosibles, rand(1, 4)));

                // Seleccionar ayudas recibidas aleatorias (puede estar vacío)
                $ayudasSeleccionadas = rand(0, 1) ? implode(', ', $this->array_random($ayudasRecibidas, rand(1, 3))) : null;

                // Seleccionar vías afectadas aleatorias
                $viasAfectadasSeleccionadas = implode(', ', $this->array_random($viasAfectadas, rand(1, 3)));

                // Crear el reporte comunitario
                ReporteComunitario::create([
                    'formulario_id' => $formulario->id,
                    'incendios_registrados' => $incendiosRegistrados,
                    'incendios_activos' => $incendiosActivos,
                    'necesidades' => $necesidadesSeleccionadas,
                    'ayuda_recibida' => $ayudasSeleccionadas,
                    'num_familias_afectadas' => $numFamiliasAfectadas,
                    'num_familias_damnificadas' => $numFamiliasDamnificadas,
                    'num_personas_evacuadas' => $numPersonasEvacuadas,
                    'vias_acceso_afectadas' => $viasAfectadasSeleccionadas,
                ]);
            } catch (\Exception $e) {
                $this->command->error("Error creando reporte comunitario para formulario {$formulario->id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\nReportes comunitarios creados exitosamente.");
    }

    /**
     * Función auxiliar para seleccionar elementos aleatorios de un array
     * (Laravel ya tiene array_random pero por si acaso implementamos una alternativa)
     */
    private function array_random($array, $num = 1)
    {
        $keys = array_rand($array, $num);

        if ($num == 1) {
            return [$array[$keys]];
        }

        $results = [];
        foreach ($keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }
}
