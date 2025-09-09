<?php

namespace Database\Seeders;

use App\Models\Catalogo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array de datos a insertar. Se han agrupado por tipo para mayor claridad.
        $catalogos = [
            // NUEVAS ENFERMEDADES
            [
                'nombre' => 'Conjuntivitis',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Inflamación de la conjuntiva del ojo.'
            ],
            [
                'nombre' => 'Respiratorias Agudas',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Infección del sistema respiratorio superior.'
            ],
            [
                'nombre' => 'Neumonías',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Infección de los pulmones.'
            ],
            [
                'nombre' => 'EDAs',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Enfermedades Diarreicas Agudas'
            ],
            [
                'nombre' => 'IRAs',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Infecciones Respiratorias Agudas.'
            ],
            [
                'nombre' => 'Fallecimientos',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Número de muertes relacionadas con las enfermedades mencionadas.'
            ],

            // Enfermedades
            [
                'nombre' => 'Asma',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Enfermedad respiratoria crónica'
            ],
            [
                'nombre' => 'Dermatitis',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Inflamación de la piel'
            ],
            [
                'nombre' => 'Infección Respiratoria',
                'tipo' => 'enfermedad',
                'contexto' => 'salud',
                'descripcion' => 'Infecciones que afectan el sistema respiratorio'
            ],

            // Modalidades educación
            [
                'nombre' => 'Presencial',
                'tipo' => 'modalidad_educacion',
                'contexto' => 'educacion',
                'descripcion' => 'Educación con asistencia física a un centro educativo'
            ],
            [
                'nombre' => 'Semi-presencial',
                'tipo' => 'modalidad_educacion',
                'contexto' => 'educacion',
                'descripcion' => 'Educación que combina sesiones presenciales y virtuales'
            ],
            [
                'nombre' => 'Virtual',
                'tipo' => 'modalidad_educacion',
                'contexto' => 'educacion',
                'descripcion' => 'Educación impartida completamente en línea'
            ],

             // Instituciones educativas
            [
                'nombre' => 'Unidades Educativas',
                'tipo' => 'institucion',
                'contexto' => 'educacion',
                'descripcion' => 'Centros de educación básica (inicial, primaria y secundaria).'
            ],
            [
                'nombre' => 'Universidades',
                'tipo' => 'institucion',
                'contexto' => 'educacion',
                'descripcion' => 'Instituciones de educación superior universitaria.'
            ],
            [
                'nombre' => 'Institutos de Formación Técnica y Superior',
                'tipo' => 'institucion',
                'contexto' => 'educacion',
                'descripcion' => 'Instituciones que ofrecen formación técnica y tecnológica superior.'
            ],

            // Infraestructura
            [
                'nombre' => 'Viviendas',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'infraestructura',
                'descripcion' => 'Viviendas particulares o comunales'
            ],
            [
                'nombre' => 'Potreros',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'agropecuario',
                'descripcion' => 'Áreas destinadas al pastoreo de ganado'
            ],
            [
                'nombre' => 'Ganadera',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'agropecuario',
                'descripcion' => 'Infraestructura destinada a la ganadería'
            ],
            [
                'nombre' => 'UE afectadas por incendio',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'educacion',
                'descripcion' => 'Unidades Educativas dañadas por incendio'
            ],
            [
                'nombre' => 'UE utilizadas como albergues',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'educacion',
                'descripcion' => 'Unidades Educativas habilitadas como albergues temporales'
            ],
            [
                'nombre' => 'Puentes',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'infraestructura',
                'descripcion' => 'Estructuras viales para cruce de ríos o quebradas'
            ],
            [
                'nombre' => 'Pozos de Peces',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'acuicola',
                'descripcion' => 'Infraestructura para la crianza de peces'
            ],
            [
                'nombre' => 'Agrícola',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'agricultura',
                'descripcion' => 'Infraestructura destinada a actividades agrícolas'
            ],
            [
                'nombre' => 'Escuela',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'educacion',
                'descripcion' => 'Infraestructura educativa para enseñanza'
            ],
            [
                'nombre' => 'Centro de Salud',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'salud',
                'descripcion' => 'Infraestructura para atención médica básica'
            ],
            [
                'nombre' => 'Carretera',
                'tipo' => 'tipo_infraestructura',
                'contexto' => 'infraestructura',
                'descripcion' => 'Vía de transporte terrestre'
            ],

            // Servicios básicos
            [
                'nombre' => 'Luz eléctrica',
                'tipo' => 'tipo_servicio',
                'contexto' => 'servicio',
                'descripcion' => 'Suministro de energía eléctrica'
            ],
            [
                'nombre' => 'Agua potable',
                'tipo' => 'tipo_servicio',
                'contexto' => 'servicio',
                'descripcion' => 'Suministro de agua para consumo humano'
            ],
            [
                'nombre' => 'Alcantarillado',
                'tipo' => 'tipo_servicio',
                'contexto' => 'servicio',
                'descripcion' => 'Sistema de evacuación de aguas residuales'
            ],
            [
                'nombre' => 'Telecomunicaciones',
                'tipo' => 'tipo_servicio',
                'contexto' => 'servicio',
                'descripcion' => 'Servicios de telefonía y comunicación'
            ],
            [
                'nombre' => 'Caminos',
                'tipo' => 'tipo_servicio',
                'contexto' => 'infraestructura',
                'descripcion' => 'Vías de acceso local o vecinal'
            ],
            [
                'nombre' => 'Internet',
                'tipo' => 'tipo_servicio',
                'contexto' => 'servicio',
                'descripcion' => 'Servicio de conectividad a internet'
            ],


            // Tipos de especie (pecuario)
            [
                'nombre' => 'Ganado Bovino',
                'tipo' => 'tipo_especie',
                'contexto' => 'pecuario',
                'descripcion' => 'Especies de ganado bovino para producción de carne y leche'
            ],
            [
                'nombre' => 'Equinos',
                'tipo' => 'tipo_especie',
                'contexto' => 'pecuario',
                'descripcion' => 'Caballos, mulas y asnos'
            ],
            [
                'nombre' => 'Porcino',
                'tipo' => 'tipo_especie',
                'contexto' => 'pecuario',
                'descripcion' => 'Especies porcinas para producción de carne'
            ],
            [
                'nombre' => 'Caprino',
                'tipo' => 'tipo_especie',
                'contexto' => 'pecuario',
                'descripcion' => 'Especies caprinas para producción de leche y carne'
            ],
            [
                'nombre' => 'Aves',
                'tipo' => 'tipo_especie',
                'contexto' => 'pecuario',
                'descripcion' => 'Aves en producción pecuaria'
            ],
            [
                'nombre' => 'Piscícolas',
                'tipo' => 'tipo_especie',
                'contexto' => 'pecuario',
                'descripcion' => 'Especies de peces cultivados'
            ],
            [
                'nombre' => 'Mamíferos',
                'tipo' => 'tipo_especie',
                'contexto' => 'pecuario',
                'descripcion' => 'Mamíferos de producción'
            ],
            [
                'nombre' => 'Reptiles',
                'tipo' => 'tipo_especie',
                'contexto' => 'pecuario',
                'descripcion' => 'Reptiles de producción'
            ],

            // Tipos de cultivo (agricultura)
            [
                'nombre' => 'Maíz',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de maíz para consumo humano y animal'
            ],
            [
                'nombre' => 'Soya',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de soya para consumo humano y animal'
            ],
            [
                'nombre' => 'Arroz',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de arroz para consumo humano'
            ],
            [
                'nombre' => 'Frijol',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de frijol para consumo humano'
            ],
            [
                'nombre' => 'Sorgo',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de sorgo para uso alimenticio y forrajero'
            ],
            [
                'nombre' => 'Plátano',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de plátano para consumo y exportación'
            ],
            [
                'nombre' => 'Yuca',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de yuca para consumo y agroindustria'
            ],
            [
                'nombre' => 'Café',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de café para exportación y consumo local'
            ],
            [
                'nombre' => 'Cacao',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de cacao para la industria chocolatera'
            ],
            [
                'nombre' => 'Caña de azúcar',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de caña para producción de azúcar y biocombustibles'
            ],
            [
                'nombre' => 'Papaya',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de papaya para consumo fresco y procesamiento'
            ],
            [
                'nombre' => 'Piña',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de piña para consumo y exportación'
            ],
            [
                'nombre' => 'Sandía',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivo de sandía para consumo fresco'
            ],
            [
                'nombre' => 'Cítricos',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Grupo de cultivos cítricos (naranja, limón, mandarina, etc.)'
            ],
            [
                'nombre' => 'Hortalizas',
                'tipo' => 'tipo_cultivo',
                'contexto' => 'agricultura',
                'descripcion' => 'Cultivos hortícolas variados (tomate, pimiento, lechuga, etc.)'
            ],

            // Detalle de área forestal
            [
                'nombre' => 'Forrajes o pastizales',
                'tipo' => 'detalle_area_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Áreas cubiertas principalmente por vegetación herbácea para pastoreo'
            ],
            [
                'nombre' => 'Áreas protegidas',
                'tipo' => 'detalle_area_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Zonas bajo régimen especial de conservación'
            ],
            [
                'nombre' => 'Pampas',
                'tipo' => 'detalle_area_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Llanuras herbáceas naturales'
            ],
            [
                'nombre' => 'Bosques',
                'tipo' => 'detalle_area_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Formaciones vegetales leñosas densas'
            ],
            [
                'nombre' => 'Serranías',
                'tipo' => 'detalle_area_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Zonas montañosas con cobertura boscosa o vegetación natural'
            ],
            [
                'nombre' => 'Forestal maderable',
                'tipo' => 'detalle_area_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Bosques destinados a la producción de madera'
            ],
            [
                'nombre' => 'Bosque con castaña',
                'tipo' => 'detalle_area_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Bosques que incluyen especies de castaña'
            ],

            // Detalle de acciones / situaciones con fauna silvestre
            [
                'nombre' => 'Atención de fauna silvestre',
                'tipo' => 'detalle_fauna_silvestre',
                'contexto' => 'fauna',
                'descripcion' => 'Intervenciones médicas o de rescate de fauna silvestre'
            ],
            [
                'nombre' => 'Derivación de fauna silvestre a centros de custodio',
                'tipo' => 'detalle_fauna_silvestre',
                'contexto' => 'fauna',
                'descripcion' => 'Traslado de animales a centros de cuidado o rehabilitación'
            ],
            [
                'nombre' => 'Traslocación de fauna',
                'tipo' => 'detalle_fauna_silvestre',
                'contexto' => 'fauna',
                'descripcion' => 'Reubicación de animales de un lugar a otro dentro de su hábitat o a otro hábitat adecuado'
            ],
            [
                'nombre' => 'Deceso de animales silvestres',
                'tipo' => 'detalle_fauna_silvestre',
                'contexto' => 'fauna',
                'descripcion' => 'Registro de mortalidad de fauna silvestre'
            ],

            // Fauna (opcional)
            [
                'nombre' => 'Venado cola blanca',
                'tipo' => 'tipo_fauna',
                'contexto' => 'fauna',
                'descripcion' => 'Especie de cérvido nativo de la región'
            ],
            [
                'nombre' => 'Guacamaya roja',
                'tipo' => 'tipo_fauna',
                'contexto' => 'fauna',
                'descripcion' => 'Ave psitácida en peligro de extinción'
            ],
            [
                'nombre' => 'Jaguar',
                'tipo' => 'tipo_fauna',
                'contexto' => 'fauna',
                'descripcion' => 'Felino más grande de América'
            ],

            // Tipos de asistencia
            [
                'nombre' => 'Alimentos',
                'tipo' => 'tipo_asistencia',
                'contexto' => 'reforestacion',
                'descripcion' => 'Asistencia alimentaria para comunidades afectadas'
            ],
            [
                'nombre' => 'Herramientas',
                'tipo' => 'tipo_asistencia',
                'contexto' => 'reforestacion',
                'descripcion' => 'Herramientas para labores de reconstrucción y reforestación'
            ],
            [
                'nombre' => 'Medicamentos',
                'tipo' => 'tipo_asistencia',
                'contexto' => 'salud',
                'descripcion' => 'Asistencia médica y farmacéutica'
            ],

            // Especies forestales
            [
                'nombre' => 'Eucalipto',
                'tipo' => 'especie_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Árbol de crecimiento rápido para reforestación'
            ],
            [
                'nombre' => 'Pino',
                'tipo' => 'especie_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Árbol conífero usado en proyectos forestales'
            ],
            [
                'nombre' => 'Caoba',
                'tipo' => 'especie_forestal',
                'contexto' => 'forestal',
                'descripcion' => 'Árbol maderable de alto valor'
            ],
        ];

            $bar = $this->command->getOutput()->createProgressBar(count($catalogos));
        $bar->start();

        foreach ($catalogos as $catalogo) {
            try {
                // firstOrCreate evita duplicados y crea el registro si no existe
                Catalogo::firstOrCreate(
                    ['tipo' => $catalogo['tipo'], 'nombre' => $catalogo['nombre']],
                    $catalogo
                );
            } catch (\Exception $e) {
                // Manejo de errores en caso de que la inserción falle
                Log::error('Error al crear catálogo: ' . $e->getMessage());
                $this->command->error("Error creating catalog: {$catalogo['nombre']}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\n" . count($catalogos) . ' catalogos han sido creados/existen.');
    }
}
