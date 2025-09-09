<?php

namespace Database\Seeders;

use App\Models\Formulario;
use App\Models\Comunidad;
use App\Models\Incendio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FormularioSeeder extends Seeder
{
    public function run(): void
    {
        $comunidades = Comunidad::all()->keyBy('nombre');
        $incendios   = Incendio::all()->keyBy('codigo_incendio');

        if ($comunidades->isEmpty() || $incendios->isEmpty()) {
            $this->command->error('⚠️  Ejecuta primero los seeders de Comunidades e Incendios.');
            return;
        }

        // Usar solo comunidades que realmente existen
        $formularios = [
            [
                'estado'              => 'validado',
                'fecha_llenado'       => '2024-03-01',
                'nombre_encuestador'  => 'Juan Pérez',
                'contacto_encuestador'=> 'juan.perez@email.com',
                'comunidad_nombre'    => 'Copacabana', // Esta comunidad existe
                'incendio_codigo'     => 'INC-2024-001',
            ],
            [
                'estado'              => 'completado',
                'fecha_llenado'       => '2024-03-05',
                'nombre_encuestador'  => 'María García',
                'contacto_encuestador'=> 'maria.garcia@email.com',
                'comunidad_nombre'    => 'Los Puentes', // Esta comunidad existe
                'incendio_codigo'     => 'INC-2024-002',
            ],
            [
                'estado'              => 'borrador',
                'fecha_llenado'       => '2024-03-10',
                'nombre_encuestador'  => 'Carlos López',
                'contacto_encuestador'=> 'carlos.lopez@email.com',
                'comunidad_nombre'    => 'Puerto Almacén', // Esta comunidad existe
                'incendio_codigo'     => 'INC-2024-003',
            ],
            [
                'estado'              => 'validado',
                'fecha_llenado'       => '2024-03-15',
                'nombre_encuestador'  => 'Ana Rodríguez',
                'contacto_encuestador'=> 'ana.rodriguez@email.com',
                'comunidad_nombre'    => 'Ibiato', // Esta comunidad existe
                'incendio_codigo'     => 'INC-2024-004',
            ],
            [
                'estado'              => 'rechazado',
                'fecha_llenado'       => '2024-03-20',
                'nombre_encuestador'  => 'Luis Martínez',
                'contacto_encuestador'=> 'luis.martinez@email.com',
                'comunidad_nombre'    => 'Loma Suárez', // Esta comunidad existe
                'incendio_codigo'     => 'INC-2024-005',
            ],
            // Repetir algunas comunidades ya que solo tenemos 5
            [
                'estado'              => 'completado',
                'fecha_llenado'       => '2024-03-25',
                'nombre_encuestador'  => 'Elena Sánchez',
                'contacto_encuestador'=> 'elena.sanchez@email.com',
                'comunidad_nombre'    => 'Copacabana', // Repetir comunidad existente
                'incendio_codigo'     => 'INC-2024-006',
            ],
            [
                'estado'              => 'validado',
                'fecha_llenado'       => '2024-03-30',
                'nombre_encuestador'  => 'Pedro Gómez',
                'contacto_encuestador'=> 'pedro.gomez@email.com',
                'comunidad_nombre'    => 'Los Puentes', // Repetir comunidad existente
                'incendio_codigo'     => 'INC-2024-007',
            ],
        ];

        $bar = $this->command->getOutput()->createProgressBar(count($formularios));
        $bar->start();

        foreach ($formularios as $i => $f) {
            $comunidad = $comunidades->get($f['comunidad_nombre']);
            $incendio  = $incendios->get($f['incendio_codigo']);

            if (!$comunidad || !$incendio) {
                $this->command->warn("❌ Saltando formulario #".($i+1)." – Comunidad o incendio no encontrado.");
                $bar->advance();
                continue;
            }

            Formulario::create([
                'codigo_formulario'   => 'FORM-2024-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'estado'              => $f['estado'],
                'fecha_llenado'       => $f['fecha_llenado'],
                'nombre_encuestador'  => $f['nombre_encuestador'],
                'contacto_encuestador'=> $f['contacto_encuestador'],
                'comunidad_id'        => $comunidad->id,
                'incendio_id'         => $incendio->id,
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\n✅ Formularios creados exitosamente.");
    }
}
