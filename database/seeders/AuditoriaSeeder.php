<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use Illuminate\Database\Seeder;

class AuditoriaSeeder extends Seeder
{
    public function run(): void
    {
        $tablas = ['formularios', 'incendios', 'comunidades', 'catalogos'];
        $ops    = ['insert', 'update', 'delete'];

        foreach (range(1, 50) as $i) {
            Auditoria::create([
                'tabla_afectada'      => fake()->randomElement($tablas),
                'operacion'           => fake()->randomElement($ops),
                'valores_anteriores'  => ['campo' => 'valor_antes'],
                'valores_nuevos'      => ['campo' => 'valor_despues'],
                'usuario'             => fake()->userName(),
                'ip_address'          => fake()->ipv4(),
                'user_agent'          => fake()->userAgent(),
                'fecha_operacion'     => now()->subDays($i),
            ]);
        }
    }
}
