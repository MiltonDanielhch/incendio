<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComunidadSeeder extends Seeder
{
    public function run(): void
    {
        $comunidades = [
            // Trinidad
            ['nombre' => 'Copacabana', 'tipo_comunidad' => 'rural', 'municipio_id' => 1, 'latitud' => -14.8333, 'longitud' => -64.9167, 'direccion' => 'Comunidad Copacabana', 'referencia' => 'A orillas del río Mamoré'],
            ['nombre' => 'Los Puentes', 'tipo_comunidad' => 'rural', 'municipio_id' => 1, 'latitud' => -14.6, 'longitud' => -64.8833, 'direccion' => 'Comunidad Los Puentes', 'referencia' => 'A 14 km de Trinidad'],
            ['nombre' => 'Puerto Almacén', 'tipo_comunidad' => 'rural', 'municipio_id' => 1, 'latitud' => -14.8, 'longitud' => -64.9, 'direccion' => 'Comunidad Puerto Almacén', 'referencia' => 'A orillas del río Mamoré'],
            ['nombre' => 'Ibiato', 'tipo_comunidad' => 'rural', 'municipio_id' => 1, 'latitud' => -14.85, 'longitud' => -64.95, 'direccion' => 'Comunidad Ibiato', 'referencia' => 'Cerca de Trinidad'],
            ['nombre' => 'Loma Suárez', 'tipo_comunidad' => 'rural', 'municipio_id' => 1, 'latitud' => -14.7, 'longitud' => -64.8, 'direccion' => 'Comunidad Loma Suárez', 'referencia' => 'Con acceso por carretera'],

            // San Javier (ID: 2)
            ['nombre' => '27 de Mayo', 'tipo_comunidad' => 'rural', 'municipio_id' => 2, 'latitud' => -14.75, 'longitud' => -64.82, 'direccion' => 'Comunidad 27 de Mayo', 'referencia' => 'Comunidad agrícola'],
            ['nombre' => 'San Javier', 'tipo_comunidad' => 'rural', 'municipio_id' => 2, 'latitud' => -14.6, 'longitud' => -64.8833, 'direccion' => 'Comunidad San Javier', 'referencia' => 'En la Provincia Cercado'],

            // Santa Ana del Yacuma (ID: 3)
            ['nombre' => 'El Piraí', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7445, 'longitud' => -65.4243, 'direccion' => 'Comunidad El Piraí', 'referencia' => 'Junto a reserva natural'],
            ['nombre' => 'El Retoño', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7589, 'longitud' => -65.4156, 'direccion' => 'Comunidad El Retoño', 'referencia' => 'Zona ganadera'],
            ['nombre' => 'Los Tres Mandarinos', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7392, 'longitud' => -65.4310, 'direccion' => 'Comunidad Los Tres Mandarinos', 'referencia' => 'Fruticultura'],
            ['nombre' => 'Santa María del Apere', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7801, 'longitud' => -65.3987, 'direccion' => 'Comunidad Santa María del Apere', 'referencia' => 'Ribera del río Apere'],
            ['nombre' => 'Nueva Esperanza', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7634, 'longitud' => -65.4098, 'direccion' => 'Comunidad Nueva Esperanza', 'referencia' => 'Asentamiento agrícola'],
            ['nombre' => 'Chaco Brasil', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7267, 'longitud' => -65.4432, 'direccion' => 'Comunidad Chaco Brasil', 'referencia' => 'Cerca de frontera'],
            ['nombre' => 'El Cedral', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7512, 'longitud' => -65.4178, 'direccion' => 'Comunidad El Cedral', 'referencia' => 'Zona de cedro'],
            ['nombre' => 'Aguas Negras', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7703, 'longitud' => -65.3854, 'direccion' => 'Comunidad Aguas Negras', 'referencia' => 'Laguna cercana'],
            ['nombre' => 'San Joaquín del Maniqui', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7823, 'longitud' => -65.3712, 'direccion' => 'Comunidad San Joaquín del Maniqui', 'referencia' => 'Junto al río Maniqui'],
            ['nombre' => 'El Perú Río Apere', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7945, 'longitud' => -65.3567, 'direccion' => 'Comunidad El Perú Río Apere', 'referencia' => 'En la cuenca del Apere'],
            ['nombre' => 'Cero Ocho', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7356, 'longitud' => -65.4289, 'direccion' => 'Comunidad Cero Ocho', 'referencia' => 'Km 8 de la carretera'],
            ['nombre' => 'Turindi', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7489, 'longitud' => -65.4112, 'direccion' => 'Comunidad Turindi', 'referencia' => 'Área de palmeras'],
            ['nombre' => 'Soberanía', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7612, 'longitud' => -65.4056, 'direccion' => 'Comunidad Soberanía', 'referencia' => 'Aniversario 1985'],
            ['nombre' => 'El Lipimo', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7298, 'longitud' => -65.4378, 'direccion' => 'Comunidad El Lipimo', 'referencia' => 'Zona ribereña'],
            ['nombre' => '18 de Noviembre', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7734, 'longitud' => -65.3912, 'direccion' => 'Comunidad 18 de Noviembre', 'referencia' => 'Aniversario departamental'],
            ['nombre' => 'La Finca', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7545, 'longitud' => -65.4134, 'direccion' => 'Comunidad La Finca', 'referencia' => 'Ex-hacienda agrícola'],
            ['nombre' => 'Cotoca de Moseruna', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7689, 'longitud' => -65.3834, 'direccion' => 'Comunidad Cotoca de Moseruna', 'referencia' => 'Asentamiento mojeño'],
            ['nombre' => 'Maniquicito I', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7401, 'longitud' => -65.4198, 'direccion' => 'Comunidad Maniquicito I', 'referencia' => 'Primer asentamiento'],
            ['nombre' => 'Mapajo La Rampa', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7777, 'longitud' => -65.3932, 'direccion' => 'Comunidad Mapajo La Rampa', 'referencia' => 'Cerca del afluente Mapajo'],
            ['nombre' => 'Buen Día', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7323, 'longitud' => -65.4256, 'direccion' => 'Comunidad Buen Día', 'referencia' => 'Nombre evangélico'],
            ['nombre' => 'Totaizal', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7589, 'longitud' => -65.4087, 'direccion' => 'Comunidad Totaizal', 'referencia' => 'Zona de totaí'],
            ['nombre' => 'San Miguel del Apere', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7845, 'longitud' => -65.3745, 'direccion' => 'Comunidad San Miguel del Apere', 'referencia' => 'Patrono San Miguel'],
            ['nombre' => 'San Pedro del Apere', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7912, 'longitud' => -65.3678, 'direccion' => 'Comunidad San Pedro del Apere', 'referencia' => 'Patrono San Pedro'],
            ['nombre' => 'Carmen del Iruyañez', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7723, 'longitud' => -65.3890, 'direccion' => 'Comunidad Carmen del Iruyañez', 'referencia' => 'Virgen del Carmen'],
            ['nombre' => 'Miraflores', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7456, 'longitud' => -65.4212, 'direccion' => 'Comunidad Miraflores', 'referencia' => 'Vista panorámica'],
            ['nombre' => 'Carnavales', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7690, 'longitud' => -65.3967, 'direccion' => 'Comunidad Carnavales', 'referencia' => 'Fiesta tradicional'],
            ['nombre' => 'Carmen del Matto', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7765, 'longitud' => -65.3889, 'direccion' => 'Comunidad Carmen del Matto', 'referencia' => 'Zona de mato'],
            ['nombre' => 'San Juan del Remanzo', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7801, 'longitud' => -65.3854, 'direccion' => 'Comunidad San Juan del Remanzo', 'referencia' => 'Río remansado'],
            ['nombre' => 'Montes de Oro', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7667, 'longitud' => -65.3998, 'direccion' => 'Comunidad Montes de Oro', 'referencia' => 'Colinas doradas'],
            ['nombre' => 'Villa Fátima', 'tipo_comunidad' => 'rural', 'municipio_id' => 3, 'latitud' => -13.7498, 'longitud' => -65.4165, 'direccion' => 'Comunidad Villa Fátima', 'referencia' => 'Devoción mariana'],

            // Exaltación (ID: 4)
            ['nombre' => 'Las Abras', 'tipo_comunidad' => 'rural', 'municipio_id' => 4, 'latitud' => -14.3167, 'longitud' => -67.3833, 'direccion' => 'Comunidad Las Abras', 'referencia' => 'Zona de sabana al suroeste de Exaltación'],

            // San Ignacio de Moxos (ID: 5)
            ['nombre' => 'San Lorenzo',        'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.0833, 'longitud' => -65.7500, 'direccion' => 'Comunidad San Lorenzo',        'referencia' => 'A orillas del río Apere'],
            ['nombre' => 'Litoral',            'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.0745, 'longitud' => -65.7389, 'direccion' => 'Comunidad Litoral',            'referencia' => 'Zona ribereña del Beni'],
            ['nombre' => 'Ichasawasare',       'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.1012, 'longitud' => -65.7610, 'direccion' => 'Comunidad Ichasawasare',       'referencia' => 'Asentamiento mojeño tradicional'],
            ['nombre' => 'Flores Coloradas',   'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.0623, 'longitud' => -65.7290, 'direccion' => 'Comunidad Flores Coloradas',   'referencia' => 'Camino a la reserva de fauna'],
            ['nombre' => 'Chanequeré',         'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.0890, 'longitud' => -65.7445, 'direccion' => 'Comunidad Chanequeré',         'referencia' => 'Zona de chacos y lagunas'],
            ['nombre' => 'San Pablo',          'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.0710, 'longitud' => -65.7550, 'direccion' => 'Comunidad San Pablo',          'referencia' => 'Fiesta patronal en junio'],
            ['nombre' => 'Bella Brisa',        'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.0945, 'longitud' => -65.7630, 'direccion' => 'Comunidad Bella Brisa',        'referencia' => 'Vista panorámica a la sabana'],
            ['nombre' => 'San Ignacito',       'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.0790, 'longitud' => -65.7400, 'direccion' => 'Comunidad San Ignacito',       'referencia' => 'Anexo de San Ignacio de Moxos'],
            ['nombre' => 'Las Mercedes del Apere', 'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.0600, 'longitud' => -65.7200, 'direccion' => 'Comunidad Las Mercedes del Apere', 'referencia' => 'Cerca del puente sobre el Apere'],
            ['nombre' => 'Tipnis',             'tipo_comunidad' => 'rural', 'municipio_id' => 5, 'latitud' => -15.1100, 'longitud' => -65.7800, 'direccion' => 'Comunidad Tipnis',             'referencia' => 'Límite con el TIPNIS'],

            // Santos Reyes (ID: 6)
            ['nombre' => 'Carmen Alto del Genesguaya', 'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4333, 'longitud' => -67.5333, 'direccion' => 'Comunidad Carmen Alto del Genesguaya', 'referencia' => 'Zona alta del río Genesguaya'],
            ['nombre' => 'Recreo',                     'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4400, 'longitud' => -67.5200, 'direccion' => 'Comunidad Recreo',                     'referencia' => 'Área de descanso ribereña'],
            ['nombre' => 'San Felipe',                 'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4250, 'longitud' => -67.5400, 'direccion' => 'Comunidad San Felipe',                 'referencia' => 'Fiesta patronal en mayo'],
            ['nombre' => 'Misión Cavina',              'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4500, 'longitud' => -67.5100, 'direccion' => 'Comunidad Misión Cavina',              'referencia' => 'Antigua misión jesuita'],
            ['nombre' => 'Carmen Alto del Beni',       'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4100, 'longitud' => -67.5500, 'direccion' => 'Comunidad Carmen Alto del Beni',       'referencia' => 'Altiplanicie sobre el Beni'],
            ['nombre' => 'Baquetty',                   'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4650, 'longitud' => -67.5050, 'direccion' => 'Comunidad Baquetty',                   'referencia' => 'Zona de palmar y ganado'],
            ['nombre' => 'Campo Bolívar',              'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4200, 'longitud' => -67.5250, 'direccion' => 'Comunidad Campo Bolívar',              'referencia' => 'Homenaje al Libertador'],
            ['nombre' => 'Centrito',                   'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4450, 'longitud' => -67.5150, 'direccion' => 'Comunidad Centrito',                   'referencia' => 'Punto intermedio de la ruta'],
            ['nombre' => 'San Jose del Biata',         'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4700, 'longitud' => -67.5000, 'direccion' => 'Comunidad San Jose del Biata',         'referencia' => 'Desembocadura del Biata'],
            ['nombre' => 'Natividad',                  'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4300, 'longitud' => -67.5280, 'direccion' => 'Comunidad Natividad',                  'referencia' => 'Celebración navideña tradicional'],
            ['nombre' => 'Monterrey',                  'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4550, 'longitud' => -67.5120, 'direccion' => 'Comunidad Monterrey',                  'referencia' => 'Colinas bajas y sabana'],
            ['nombre' => 'San Miguel',                 'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4150, 'longitud' => -67.5450, 'direccion' => 'Comunidad San Miguel',                 'referencia' => 'Patrono San Miguel Arcángel'],
            ['nombre' => 'San Marcos',                 'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4600, 'longitud' => -67.5080, 'direccion' => 'Comunidad San Marcos',                 'referencia' => 'Junio, mes de fiesta patronal'],
            ['nombre' => 'Candelaria',                 'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4400, 'longitud' => -67.5220, 'direccion' => 'Comunidad Candelaria',                 'referencia' => '2 de febrero, Virgen de la Candelaria'],
            ['nombre' => 'Santa Catalina',             'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4750, 'longitud' => -67.4980, 'direccion' => 'Comunidad Santa Catalina',             'referencia' => 'Zona de chacos y esteros'],
            ['nombre' => 'El Cozar',                   'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4500, 'longitud' => -67.5180, 'direccion' => 'Comunidad El Cozar',                   'referencia' => 'Lomerío con cochal'],
            ['nombre' => 'Villa Copacabana',           'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4350, 'longitud' => -67.5300, 'direccion' => 'Comunidad Villa Copacabana',           'referencia' => 'Vista al lago Cuchillo'],
            ['nombre' => 'San José',                   'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4800, 'longitud' => -67.4950, 'direccion' => 'Comunidad San José',                   'referencia' => 'Festival de San José en marzo'],
            ['nombre' => 'Guaguauno',                  'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4250, 'longitud' => -67.5350, 'direccion' => 'Comunidad Guaguauno',                  'referencia' => 'Asentamiento guarayo'],
            ['nombre' => 'Río Viejo',                  'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4900, 'longitud' => -67.4850, 'direccion' => 'Comunidad Río Viejo',                  'referencia' => 'Meandro antiguo del Beni'],
            ['nombre' => 'Puerto Salinas',             'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4650, 'longitud' => -67.5100, 'direccion' => 'Comunidad Puerto Salinas',             'referencia' => 'Desembarcadero salitrado'],
            ['nombre' => 'San Juan',                   'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4550, 'longitud' => -67.5150, 'direccion' => 'Comunidad San Juan',                   'referencia' => 'Acceso por trocha al Beni'],
            ['nombre' => 'Rotije',                     'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4700, 'longitud' => -67.5020, 'direccion' => 'Comunidad Rotije',                     'referencia' => 'Zona de rotijeales'],
            ['nombre' => 'San Pedro',                  'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4450, 'longitud' => -67.5250, 'direccion' => 'Comunidad San Pedro',                  'referencia' => 'Fiesta de San Pedro y San Pablo'],
            ['nombre' => 'Salsipuedes',                'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4850, 'longitud' => -67.4900, 'direccion' => 'Comunidad Salsipuedes',                'referencia' => 'Antiguo paso comercial'],
            ['nombre' => 'Monte Carlos',               'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4600, 'longitud' => -67.5130, 'direccion' => 'Comunidad Monte Carlos',               'referencia' => 'Colinas bajas y sabanas'],
            ['nombre' => 'Baychuje',                   'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4750, 'longitud' => -67.5000, 'direccion' => 'Comunidad Baychuje',                   'referencia' => 'Zona de baychujeales'],
            ['nombre' => 'Gualaguagua',                'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4500, 'longitud' => -67.5200, 'direccion' => 'Comunidad Gualaguagua',                'referencia' => 'Territorio guarasug’we'],
            ['nombre' => 'Zoraida',                    'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4800, 'longitud' => -67.4950, 'direccion' => 'Comunidad Zoraida',                    'referencia' => 'Nombre de fundadora'],
            ['nombre' => 'Nuevo Reyes',                'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4400, 'longitud' => -67.5300, 'direccion' => 'Comunidad Nuevo Reyes',                'referencia' => 'Asentamiento reciente'],
            ['nombre' => 'Las Penitas',                'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4700, 'longitud' => -67.5050, 'direccion' => 'Comunidad Las Penitas',                'referencia' => 'Zona de penascales'],
            ['nombre' => 'Peña Guarayo',               'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4550, 'longitud' => -67.5180, 'direccion' => 'Comunidad Peña Guarayo',               'referencia' => 'Territorio guarayo ancestral'],
            ['nombre' => 'Nueva Alianza',              'tipo_comunidad' => 'rural', 'municipio_id' => 6, 'latitud' => -14.4650, 'longitud' => -67.5120, 'direccion' => 'Comunidad Nueva Alianza',              'referencia' => 'Cooperativa agropecuaria'],

            // Santa Rosa de Yacuma (ID: 7)
            ['nombre' => 'San Cristóbal', 'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2667, 'longitud' => -64.0500, 'direccion' => 'Comunidad San Cristóbal', 'referencia' => 'Patrono San Cristóbal'],
            ['nombre' => 'Villa Fátima',  'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2800, 'longitud' => -64.0400, 'direccion' => 'Comunidad Villa Fátima',  'referencia' => 'Devoción mariana'],
            ['nombre' => 'Aguaysal',      'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2500, 'longitud' => -64.0700, 'direccion' => 'Comunidad Aguaysal',      'referencia' => 'Salitrales y lagunas'],
            ['nombre' => 'Triunfo',       'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2750, 'longitud' => -64.0350, 'direccion' => 'Comunidad Triunfo',       'referencia' => 'Aniversario 20 de octubre'],
            ['nombre' => 'Puerto Yata',   'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2400, 'longitud' => -64.0800, 'direccion' => 'Comunidad Puerto Yata',   'referencia' => 'Desembarcadero Yata'],
            ['nombre' => 'Tacuaral',      'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2900, 'longitud' => -64.0250, 'direccion' => 'Comunidad Tacuaral',      'referencia' => 'Bosque de tacuarales'],
            ['nombre' => 'Candado',       'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2600, 'longitud' => -64.0550, 'direccion' => 'Comunidad Candado',       'referencia' => 'Curva cerrada en la carretera'],
            ['nombre' => 'Cerrito',       'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2850, 'longitud' => -64.0300, 'direccion' => 'Comunidad Cerrito',       'referencia' => 'Lomerío en la sabana'],
            ['nombre' => 'Palmaflor',     'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2450, 'longitud' => -64.0650, 'direccion' => 'Comunidad Palmaflor',     'referencia' => 'Cultivos de palma aceitera'],
            ['nombre' => 'Australia',     'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2700, 'longitud' => -64.0450, 'direccion' => 'Comunidad Australia',     'referencia' => 'Nombre evocador de colonos'],
            ['nombre' => 'Cabador',       'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2550, 'longitud' => -64.0600, 'direccion' => 'Comunidad Cabador',       'referencia' => 'Paso de caballos en la sabana'],
            ['nombre' => 'Mojón',         'tipo_comunidad' => 'rural', 'municipio_id' => 7, 'latitud' => -13.2750, 'longitud' => -64.0350, 'direccion' => 'Comunidad Mojón',         'referencia' => 'Límite entre comunidades'],

            // San Borja (ID: 8)
            ['nombre' => 'Galilea',                 'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8167, 'longitud' => -66.8500, 'direccion' => 'Comunidad Galilea',                 'referencia' => 'Colina con vista al río'],
            ['nombre' => 'El Triunfo',              'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8300, 'longitud' => -66.8400, 'direccion' => 'Comunidad El Triunfo',              'referencia' => 'Aniversario 20 de octubre'],
            ['nombre' => 'Ivasichi',                'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8000, 'longitud' => -66.8600, 'direccion' => 'Comunidad Ivasichi',                'referencia' => 'Asentamiento mojeño tradicional'],
            ['nombre' => 'Villa Gonzáles',          'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8200, 'longitud' => -66.8300, 'direccion' => 'Comunidad Villa Gonzáles',          'referencia' => 'Fundada por familia Gonzáles'],
            ['nombre' => 'Tierra Santa',            'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8100, 'longitud' => -66.8450, 'direccion' => 'Comunidad Tierra Santa',            'referencia' => 'Nombre evangélico'],
            ['nombre' => 'Carmen del Yacuma',       'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8400, 'longitud' => -66.8200, 'direccion' => 'Comunidad Carmen del Yacuma',       'referencia' => 'Virgen del Carmen en margen del Yacuma'],
            ['nombre' => 'Las Maravillas',          'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8050, 'longitud' => -66.8550, 'direccion' => 'Comunidad Las Maravillas',          'referencia' => 'Paisaje de sabanas y lagunas'],
            ['nombre' => 'Oriende del Yacuma',      'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8500, 'longitud' => -66.8150, 'direccion' => 'Comunidad Oriende del Yacuma',      'referencia' => 'Oriente del río Yacuma'],
            ['nombre' => 'Puerto Triunfo',          'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8250, 'longitud' => -66.8350, 'direccion' => 'Comunidad Puerto Triunfo',          'referencia' => 'Desembarcadero fluvial'],
            ['nombre' => 'Agua Zarca',              'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8350, 'longitud' => -66.8250, 'direccion' => 'Comunidad Agua Zarca',              'referencia' => 'Manantial de aguas claras'],
            ['nombre' => 'Canaán',                  'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8150, 'longitud' => -66.8520, 'direccion' => 'Comunidad Canaán',                  'referencia' => 'Tierra de promesa'],
            ['nombre' => 'Edén',                    'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8400, 'longitud' => -66.8180, 'direccion' => 'Comunidad Edén',                    'referencia' => 'Nombre bíblico para la comunidad'],
            ['nombre' => 'Las Palmeras',            'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8000, 'longitud' => -66.8650, 'direccion' => 'Comunidad Las Palmeras',            'referencia' => 'Palmerales de motacú'],
            ['nombre' => 'Santa Elena del Caripo',  'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8450, 'longitud' => -66.8100, 'direccion' => 'Comunidad Santa Elena del Caripo',  'referencia' => 'Cerca del afluente Caripo'],
            ['nombre' => 'Mercedes',                'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8100, 'longitud' => -66.8600, 'direccion' => 'Comunidad Mercedes',                'referencia' => 'Patrona Nuestra Señora de las Mercedes'],
            ['nombre' => 'Tres Amigos',             'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8300, 'longitud' => -66.8380, 'direccion' => 'Comunidad Tres Amigos',             'referencia' => 'Fundada por tres familias amigas'],
            ['nombre' => 'Yacuma A',                'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8200, 'longitud' => -66.8420, 'direccion' => 'Comunidad Yacuma A',                'referencia' => 'Primera sección ribereña del Yacuma'],
            ['nombre' => 'Cachuela',                'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8350, 'longitud' => -66.8230, 'direccion' => 'Comunidad Cachuela',                'referencia' => 'Desembarcadero cachuelero'],
            ['nombre' => 'Villa Borjana',           'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8080, 'longitud' => -66.8550, 'direccion' => 'Comunidad Villa Borjana',           'referencia' => 'Homenaje a la heroína Borjana'],
            ['nombre' => 'Soledad',                 'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8450, 'longitud' => -66.8150, 'direccion' => 'Comunidad Soledad',                 'referencia' => 'Tranquilidad ribereña'],
            ['nombre' => 'El Progreso',             'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8250, 'longitud' => -66.8450, 'direccion' => 'Comunidad El Progreso',             'referencia' => 'Asociación de productores'],
            ['nombre' => 'Belén',                   'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8400, 'longitud' => -66.8200, 'direccion' => 'Comunidad Belén',                   'referencia' => 'Belén de Yacuma'],
            ['nombre' => 'San Lorenzo',             'tipo_comunidad' => 'rural', 'municipio_id' => 8, 'latitud' => -14.8000, 'longitud' => -66.8700, 'direccion' => 'Comunidad San Lorenzo',             'referencia' => 'Fiesta de San Lorenzo en agosto'],

            // Rurrenabaque (ID: 9)
            ['nombre' => 'Rio Hondo',          'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4400, 'longitud' => -67.5300, 'direccion' => 'Comunidad Rio Hondo',          'referencia' => 'Meandro profundo del Beni'],
            ['nombre' => 'Alto Colorado',      'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4200, 'longitud' => -67.5500, 'direccion' => 'Comunidad Alto Colorado',      'referencia' => 'Colinas rojizas sobre el río'],
            ['nombre' => 'Puerto Yumani',      'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4600, 'longitud' => -67.5200, 'direccion' => 'Comunidad Puerto Yumani',      'referencia' => 'Desembarcadero Yumani'],
            ['nombre' => 'Asunción Quiquibey', 'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4000, 'longitud' => -67.5600, 'direccion' => 'Comunidad Asunción Quiquibey', 'referencia' => 'Zona de reserva Quiquibey'],
            ['nombre' => 'Carmen Florida',     'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4300, 'longitud' => -67.5400, 'direccion' => 'Comunidad Carmen Florida',     'referencia' => 'Virgen del Carmen en la Florida'],
            ['nombre' => 'La Asunta',          'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4500, 'longitud' => -67.5250, 'direccion' => 'Comunidad La Asunta',          'referencia' => 'Celebración del 15 de agosto'],
            ['nombre' => 'Bibosis',            'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4100, 'longitud' => -67.5450, 'direccion' => 'Comunidad Bibosis',            'referencia' => 'Territorio tacana'],
            ['nombre' => 'San Bernardo',       'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4700, 'longitud' => -67.5150, 'direccion' => 'Comunidad San Bernardo',       'referencia' => 'Patrono San Bernardo'],
            ['nombre' => 'Wara Wara',            'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.3900, 'longitud' => -67.5700, 'direccion' => 'Comunidad Wara Wara',            'referencia' => 'Nombre en lengua tacana'],
            ['nombre' => 'El Bala',              'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4800, 'longitud' => -67.5100, 'direccion' => 'Comunidad El Bala',              'referencia' => 'Cerca del rápido El Bala'],
            ['nombre' => 'Santa Rosita',         'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4200, 'longitud' => -67.5500, 'direccion' => 'Comunidad Santa Rosita',         'referencia' => 'Pequeña capilla de Santa Rosa'],
            ['nombre' => 'Cuatro Ojitos',        'tipo_comunidad' => 'rural', 'municipio_id' => 9, 'latitud' => -14.4600, 'longitud' => -67.5250, 'direccion' => 'Comunidad Cuatro Ojitos',        'referencia' => 'Lagunas gemelas en la sabana'],

            // Loreto (ID: 10)
            ['nombre' => 'Villa Alba',   'tipo_comunidad' => 'rural', 'municipio_id' => 10, 'latitud' => -14.3167, 'longitud' => -67.3833, 'direccion' => 'Comunidad Villa Alba',   'referencia' => 'Colonia fundada en la década de 1970'],
            ['nombre' => 'Miraflores',   'tipo_comunidad' => 'rural', 'municipio_id' => 10, 'latitud' => -14.3300, 'longitud' => -67.3700, 'direccion' => 'Comunidad Miraflores',   'referencia' => 'Vista panorámica al río'],
            ['nombre' => 'Naranjito',    'tipo_comunidad' => 'rural', 'municipio_id' => 10, 'latitud' => -14.3050, 'longitud' => -67.3900, 'direccion' => 'Comunidad Naranjito',    'referencia' => 'Plantaciones de naranja'],
            ['nombre' => 'Buen Jesús',   'tipo_comunidad' => 'rural', 'municipio_id' => 10, 'latitud' => -14.3200, 'longitud' => -67.3750, 'direccion' => 'Comunidad Buen Jesús',   'referencia' => 'Capilla de Buen Jesús'],
            ['nombre' => 'Bella Selva',  'tipo_comunidad' => 'rural', 'municipio_id' => 10, 'latitud' => -14.3100, 'longitud' => -67.3850, 'direccion' => 'Comunidad Bella Selva',  'referencia' => 'Bosque de galería intocado'],

            // San Andrés (ID: 11)
            ['nombre' => 'San Andrés',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6667, 'longitud' => -64.3333, 'direccion' => 'Comunidad San Andrés',            'referencia' => 'Cabecera del municipio'],
            ['nombre' => 'Perotó',                'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6800, 'longitud' => -64.3200, 'direccion' => 'Comunidad Perotó',                'referencia' => 'Zona de palmerales'],
            ['nombre' => 'Somopae',               'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6500, 'longitud' => -64.3500, 'direccion' => 'Comunidad Somopae',               'referencia' => 'Asentamiento mojeño'],
            ['nombre' => '1ro de Mayo',           'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6700, 'longitud' => -64.3400, 'direccion' => 'Comunidad 1ro de Mayo',           'referencia' => 'Aniversario del trabajo'],
            ['nombre' => 'Villa San Andrés',      'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6600, 'longitud' => -64.3250, 'direccion' => 'Comunidad Villa San Andrés',      'referencia' => 'Extensión urbana rural'],
            ['nombre' => 'Villa San Pedro',       'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6850, 'longitud' => -64.3150, 'direccion' => 'Comunidad Villa San Pedro',       'referencia' => 'Patrono San Pedro'],
            ['nombre' => 'Puente San Pablo',      'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6550, 'longitud' => -64.3450, 'direccion' => 'Comunidad Puente San Pablo',      'referencia' => 'Paso sobre arroyo San Pablo'],
            ['nombre' => 'Buen Jesús',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6750, 'longitud' => -64.3300, 'direccion' => 'Comunidad Buen Jesús',            'referencia' => 'Capilla de Buen Jesús'],
            ['nombre' => 'San Martín de Porres',  'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6900, 'longitud' => -64.3100, 'direccion' => 'Comunidad San Martín de Porres',  'referencia' => 'Patrono San Martín'],
            ['nombre' => 'Santa Rosa',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6650, 'longitud' => -64.3350, 'direccion' => 'Comunidad Santa Rosa',            'referencia' => 'Fiesta de Santa Rosa de Lima'],
            ['nombre' => '4 de Julio',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6600, 'longitud' => -64.3500, 'direccion' => 'Comunidad 4 de Julio',            'referencia' => 'Día de la independencia local'],
            ['nombre' => 'Nueva Betania',         'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6700, 'longitud' => -64.3600, 'direccion' => 'Comunidad Nueva Betania',         'referencia' => 'Esperanza y renovación'],
            ['nombre' => 'Loma del Amor',         'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6500, 'longitud' => -64.3400, 'direccion' => 'Comunidad Loma del Amor',         'referencia' => 'Cerro con vista panorámica'],
            ['nombre' => 'La Galaxia',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6800, 'longitud' => -64.3000, 'direccion' => 'Comunidad La Galaxia',            'referencia' => 'Nombre evocador de los cielos'],
            ['nombre' => 'Rem. del Paraiso',      'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6450, 'longitud' => -64.3700, 'direccion' => 'Comunidad Remanso del Paraiso',   'referencia' => 'Playa tranquila en el Beni'],
            ['nombre' => 'Pedro Marbán',          'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6750, 'longitud' => -64.3200, 'direccion' => 'Comunidad Pedro Marbán',          'referencia' => 'Homenaje al héroe marbanista'],
            ['nombre' => 'Zamaria',               'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6550, 'longitud' => -64.3550, 'direccion' => 'Comunidad Zamaria',               'referencia' => 'Nombre de fundadora'],
            ['nombre' => 'Caimanes',              'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6900, 'longitud' => -64.3050, 'direccion' => 'Comunidad Caimanes',              'referencia' => 'Laguna con población de caimanes'],
            ['nombre' => 'Laguna Azul',           'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6400, 'longitud' => -64.3800, 'direccion' => 'Comunidad Laguna Azul',           'referencia' => 'Laguna de color turquesa'],
            ['nombre' => '13 de Agosto',          'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6850, 'longitud' => -64.3150, 'direccion' => 'Comunidad 13 de Agosto',          'referencia' => 'Aniversario departamental'],
            ['nombre' => 'Villa Cruz',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6620, 'longitud' => -64.3420, 'direccion' => 'Comunidad Villa Cruz',            'referencia' => 'Cruz milagrosa en la entrada'],
            ['nombre' => 'Pozo Honda',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6750, 'longitud' => -64.3280, 'direccion' => 'Comunidad Pozo Honda',            'referencia' => 'Pozo profundo de agua dulce'],
            ['nombre' => 'Nueva Alianza',         'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6680, 'longitud' => -64.3350, 'direccion' => 'Comunidad Nueva Alianza',         'referencia' => 'Cooperativa agrícola'],
            ['nombre' => 'Carmen del Dorado',     'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6800, 'longitud' => -64.3100, 'direccion' => 'Comunidad Carmen del Dorado',     'referencia' => 'Zona de dorados en el río'],
            ['nombre' => 'El Triunfo',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6700, 'longitud' => -64.3400, 'direccion' => 'Comunidad El Triunfo',            'referencia' => '20 de octubre, día de la victoria'],
            ['nombre' => 'Villa Alba',            'tipo_comunidad' => 'rural', 'municipio_id' => 11, 'latitud' => -15.6600, 'longitud' => -64.3500, 'direccion' => 'Comunidad Villa Alba',            'referencia' => 'Extensión rural de San Andrés'],

            // Magdalena (ID: 12)
            ['nombre' => 'Bella Vista',   'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6667, 'longitud' => -63.6667, 'direccion' => 'Comunidad Bella Vista',   'referencia' => 'Vista panorámica al río Iténez'],
            ['nombre' => 'California',    'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6800, 'longitud' => -63.6500, 'direccion' => 'Comunidad California',    'referencia' => 'Nombre evocador del estado norteamericano'],
            ['nombre' => 'Buena Vista',   'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6700, 'longitud' => -63.6600, 'direccion' => 'Comunidad Buena Vista',   'referencia' => 'Colinas con vista al Magdalena'],
            ['nombre' => 'Nueva Brema',   'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6900, 'longitud' => -63.6400, 'direccion' => 'Comunidad Nueva Brema',   'referencia' => 'Asentamiento moderno en la sabana'],
            ['nombre' => 'El Escondido',  'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6600, 'longitud' => -63.6800, 'direccion' => 'Comunidad El Escondido',  'referencia' => 'Zona boscosa alejada del río'],
            ['nombre' => 'La Soga',       'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6750, 'longitud' => -63.6550, 'direccion' => 'Comunidad La Soga',       'referencia' => 'Curva de río en forma de soga'],
            ['nombre' => 'San Borja',     'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6850, 'longitud' => -63.6450, 'direccion' => 'Comunidad San Borja',     'referencia' => 'Anexo rural de nombre homónimo'],
            ['nombre' => 'La Cayoba',     'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6650, 'longitud' => -63.6700, 'direccion' => 'Comunidad La Cayoba',     'referencia' => 'Cayo de palmas junto al río'],
            ['nombre' => 'Nueva Calama',  'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6950, 'longitud' => -63.6350, 'direccion' => 'Comunidad Nueva Calama',  'referencia' => 'Clima seco y caluroso'],
            ['nombre' => 'Cafetal',       'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6700, 'longitud' => -63.6650, 'direccion' => 'Comunidad Cafetal',       'referencia' => 'Pequeñas plantaciones de café'],
            ['nombre' => 'La Cafacha',    'tipo_comunidad' => 'rural', 'municipio_id' => 12, 'latitud' => -13.6800, 'longitud' => -63.6450, 'direccion' => 'Comunidad La Cafacha',    'referencia' => 'Zona de cafetos silvestres'],

            // Baures (ID: 13)
            ['nombre' => 'Veremos',       'tipo_comunidad' => 'rural', 'municipio_id' => 13, 'latitud' => -13.4500, 'longitud' => -63.7000, 'direccion' => 'Comunidad Veremos',       'referencia' => 'Esperanza de futuro crecimiento'],
            ['nombre' => 'El Cairo II',   'tipo_comunidad' => 'rural', 'municipio_id' => 13, 'latitud' => -13.4300, 'longitud' => -63.7200, 'direccion' => 'Comunidad El Cairo II',   'referencia' => 'Segunda colonia Cairo'],
            ['nombre' => 'Baures',        'tipo_comunidad' => 'rural', 'municipio_id' => 13, 'latitud' => -13.4400, 'longitud' => -63.7100, 'direccion' => 'Comunidad Baures',        'referencia' => 'Cabecera municipal y puerto fluvial'],

            // Huacaraje (ID: 14)
            ['nombre' => 'Huacaraje',     'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.6000, 'longitud' => -64.8833, 'direccion' => 'Comunidad Huacaraje',     'referencia' => 'Cabecera municipal sobre el río'],
            ['nombre' => 'La Embrolla',   'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.6200, 'longitud' => -64.8700, 'direccion' => 'Comunidad La Embrolla',   'referencia' => 'Curva sinuosa del río'],
            ['nombre' => 'Pariagua',      'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.5800, 'longitud' => -64.9000, 'direccion' => 'Comunidad Pariagua',      'referencia' => 'Zona de parihuales y aguajes'],
            ['nombre' => 'Isla Grande',   'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.5900, 'longitud' => -64.8900, 'direccion' => 'Comunidad Isla Grande',   'referencia' => 'Gran isla fluvial en el río'],
            ['nombre' => 'El Carmen',     'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.6100, 'longitud' => -64.8800, 'direccion' => 'Comunidad El Carmen',     'referencia' => 'Virgen del Carmen en la ribera'],
            ['nombre' => 'Besuria',       'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.5700, 'longitud' => -64.9100, 'direccion' => 'Comunidad Besuria',       'referencia' => 'Nombre de origen guarayo'],
            ['nombre' => 'Buena Hora',    'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.6300, 'longitud' => -64.8600, 'direccion' => 'Comunidad Buena Hora',    'referencia' => 'Llegada esperanzada de los primeros pobladores'],
            ['nombre' => 'San Pedro',     'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.5850, 'longitud' => -64.8950, 'direccion' => 'Comunidad San Pedro',     'referencia' => 'Fiesta de San Pedro en junio'],
            ['nombre' => 'La Esperanza',  'tipo_comunidad' => 'rural', 'municipio_id' => 14, 'latitud' => -13.6150, 'longitud' => -64.8750, 'direccion' => 'Comunidad La Esperanza',  'referencia' => 'Nombre que simboliza el futuro'],

            // San Ramón (ID: 15)
            ['nombre' => 'La Laguna',        'tipo_comunidad' => 'rural', 'municipio_id' => 15, 'latitud' => -14.4333, 'longitud' => -67.5333, 'direccion' => 'Comunidad La Laguna',        'referencia' => 'Laguna permanente en la sabana'],
            ['nombre' => 'Guarrasca',        'tipo_comunidad' => 'rural', 'municipio_id' => 15, 'latitud' => -14.4450, 'longitud' => -67.5250, 'direccion' => 'Comunidad Guarrasca',        'referencia' => 'Zona de guarascales'],
            ['nombre' => 'La Peña',          'tipo_comunidad' => 'rural', 'municipio_id' => 15, 'latitud' => -14.4200, 'longitud' => -67.5400, 'direccion' => 'Comunidad La Peña',          'referencia' => 'Cerro rocoso en la llanura'],
            ['nombre' => 'Siringalito',      'tipo_comunidad' => 'rural', 'municipio_id' => 15, 'latitud' => -14.4500, 'longitud' => -67.5200, 'direccion' => 'Comunidad Siringalito',      'referencia' => 'Pequeño siringal'],
            ['nombre' => 'Huacayane',        'tipo_comunidad' => 'rural', 'municipio_id' => 15, 'latitud' => -14.4350, 'longitud' => -67.5350, 'direccion' => 'Comunidad Huacayane',        'referencia' => 'Nombre de origen guarayo'],
            ['nombre' => 'Nicalapo',         'tipo_comunidad' => 'rural', 'municipio_id' => 15, 'latitud' => -14.4400, 'longitud' => -67.5300, 'direccion' => 'Comunidad Nicalapo',         'referencia' => 'Zona de nísperos silvestres'],

            // Riberalta (ID: 16)
            ['nombre' => 'Medio Monte',               'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0167, 'longitud' => -66.0667, 'direccion' => 'Comunidad Medio Monte',               'referencia' => 'Colina intermedia entre Riberalta y Guayaramerín'],
            ['nombre' => 'Berlín',                    'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0300, 'longitud' => -66.0500, 'direccion' => 'Comunidad Berlín',                    'referencia' => 'Nombre de colonos alemanes'],
            ['nombre' => 'Bella Flor',                'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0100, 'longitud' => -66.0800, 'direccion' => 'Comunidad Bella Flor',                'referencia' => 'Florecimiento de flores amazónicas'],
            ['nombre' => 'Nazareth',                  'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0200, 'longitud' => -66.0550, 'direccion' => 'Comunidad Nazareth',                  'referencia' => 'Nombre bíblico de la región'],
            ['nombre' => 'Warnes',                    'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0250, 'longitud' => -66.0450, 'direccion' => 'Comunidad Warnes',                    'referencia' => 'Homenaje al pueblo del oriente boliviano'],
            ['nombre' => 'San Francisco',             'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0150, 'longitud' => -66.0650, 'direccion' => 'Comunidad San Francisco',             'referencia' => 'Patrono San Francisco de Asís'],
            ['nombre' => 'El Hondo',                  'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0350, 'longitud' => -66.0400, 'direccion' => 'Comunidad El Hondo',                  'referencia' => 'Zona húmeda y profunda del río'],
            ['nombre' => 'Tumichucua',                'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0050, 'longitud' => -66.0750, 'direccion' => 'Comunidad Tumichucua',                'referencia' => 'Cerca del lago Tumichucua'],
            ['nombre' => 'San José Bajo',             'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0400, 'longitud' => -66.0350, 'direccion' => 'Comunidad San José Bajo',             'referencia' => 'Zona baja ribereña del Beni'],
            ['nombre' => 'Cayuces',                   'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0000, 'longitud' => -66.0700, 'direccion' => 'Comunidad Cayuces',                   'referencia' => 'Territorio cayuvava'],
            ['nombre' => 'Nueva Unión',               'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0250, 'longitud' => -66.0600, 'direccion' => 'Comunidad Nueva Unión',               'referencia' => 'Unión de varias familias fundadoras'],
            ['nombre' => 'Recreo',                    'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0300, 'longitud' => -66.0550, 'direccion' => 'Comunidad Recreo',                    'referencia' => 'Área de descanso y pesca'],
            ['nombre' => 'Carmen Alto',               'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0200, 'longitud' => -66.0650, 'direccion' => 'Comunidad Carmen Alto',               'referencia' => 'Zona alta sobre el río'],
            ['nombre' => 'Alta Gracia',               'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0350, 'longitud' => -66.0450, 'direccion' => 'Comunidad Alta Gracia',               'referencia' => 'Elevación con vista privilegiada'],
            ['nombre' => 'Nueva Generación Productiva', 'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0120, 'longitud' => -66.0680, 'direccion' => 'Comunidad Nueva Generación Productiva', 'referencia' => 'Cooperativa agropecuaria moderna'],
            ['nombre' => '12 de Octubre',             'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0080, 'longitud' => -66.0720, 'direccion' => 'Comunidad 12 de Octubre',             'referencia' => 'Día de la Hispanidad'],
            ['nombre' => 'Alto Ivón',                 'tipo_comunidad' => 'rural', 'municipio_id' => 16, 'latitud' => -11.0500, 'longitud' => -66.0300, 'direccion' => 'Comunidad Alto Ivón',                 'referencia' => 'Zona alta del afluente Ivón'],

            // Guayaramerín (ID: 17)
            ['nombre' => 'La Unión',                'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8167, 'longitud' => -65.3667, 'direccion' => 'Comunidad La Unión',                'referencia' => 'Unión de familias ribereñas'],
            ['nombre' => 'San Agustín',             'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8300, 'longitud' => -65.3500, 'direccion' => 'Comunidad San Agustín',             'referencia' => 'Fiesta de San Agustín en agosto'],
            ['nombre' => '1ro de Mayo',             'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8200, 'longitud' => -65.3600, 'direccion' => 'Comunidad 1ro de Mayo',             'referencia' => 'Día del trabajo y la unidad'],
            ['nombre' => '8 de Febrero',            'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8400, 'longitud' => -65.3400, 'direccion' => 'Comunidad 8 de Febrero',            'referencia' => 'Aniversario departamental del Beni'],
            ['nombre' => 'San Lorenzo',             'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8100, 'longitud' => -65.3700, 'direccion' => 'Comunidad San Lorenzo',             'referencia' => 'Fiesta patronal en agosto'],
            ['nombre' => 'San Miguel',              'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8250, 'longitud' => -65.3550, 'direccion' => 'Comunidad San Miguel',              'referencia' => 'Patrono San Miguel Arcángel'],
            ['nombre' => 'San Roque',               'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8350, 'longitud' => -65.3450, 'direccion' => 'Comunidad San Roque',               'referencia' => 'Fiesta de San Roque en agosto'],
            ['nombre' => 'Barranco Colorado',       'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8050, 'longitud' => -65.3800, 'direccion' => 'Comunidad Barranco Colorado',       'referencia' => 'Barranco arcilloso colorado'],
            ['nombre' => 'Palmazola',               'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8150, 'longitud' => -65.3650, 'direccion' => 'Comunidad Palmazola',               'referencia' => 'Palmerales de motacú y asaí'],
            ['nombre' => 'Ranchío Grande',          'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.8000, 'longitud' => -65.3900, 'direccion' => 'Comunidad Ranchío Grande',          'referencia' => 'Gran estancia ganadera'],
            ['nombre' => 'Cachuela del Mamoré',     'tipo_comunidad' => 'rural', 'municipio_id' => 17, 'latitud' => -10.7950, 'longitud' => -65.4000, 'direccion' => 'Comunidad Cachuela del Mamoré',     'referencia' => 'Desembarcadero histórico en el Mamoré'],

            // San Joaquín (ID: 18)
            ['nombre' => 'San Mateo',               'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -13.0000, 'longitud' => -64.7500, 'direccion' => 'Comunidad San Mateo',               'referencia' => 'Patrono San Mateo, fiesta en septiembre'],
            ['nombre' => 'Monte Azul',              'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -12.9850, 'longitud' => -64.7600, 'direccion' => 'Comunidad Monte Azul',              'referencia' => 'Cerro azulado en la sabana'],
            ['nombre' => 'El Huaso',                'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -12.9950, 'longitud' => -64.7400, 'direccion' => 'Comunidad El Huaso',                'referencia' => 'Tradición ganadera y cultura'],
            ['nombre' => 'Las Pavas',               'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -12.9750, 'longitud' => -64.7700, 'direccion' => 'Comunidad Las Pavas',               'referencia' => 'Árboles de pava y fauna aviar'],
            ['nombre' => 'Las Moscas',              'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -12.9900, 'longitud' => -64.7450, 'direccion' => 'Comunidad Las Moscas',              'referencia' => 'Nombre de insectos característicos'],
            ['nombre' => 'Chaco Lejos',             'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -12.9650, 'longitud' => -64.7800, 'direccion' => 'Comunidad Chaco Lejos',             'referencia' => 'Zona chaqueña alejada del río'],
            ['nombre' => 'Campo Alegre',            'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -12.9850, 'longitud' => -64.7550, 'direccion' => 'Comunidad Campo Alegre',            'referencia' => 'Ambiente festivo y productivo'],
            ['nombre' => 'Surucucu',                'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -12.9700, 'longitud' => -64.7750, 'direccion' => 'Comunidad Surucucu',                'referencia' => 'Nombre de serpiente característica'],
            ['nombre' => 'Puerto Ustarez',          'tipo_comunidad' => 'rural', 'municipio_id' => 18, 'latitud' => -12.9950, 'longitud' => -64.7300, 'direccion' => 'Comunidad Puerto Ustarez',          'referencia' => 'Desembarcadero Ustarez en el río'],

            // Puerto Siles (ID: 19)
            ['nombre' => 'Lago Bolívar',            'tipo_comunidad' => 'rural', 'municipio_id' => 19, 'latitud' => -12.5000, 'longitud' => -63.6667, 'direccion' => 'Comunidad Lago Bolívar',            'referencia' => 'Litoral del lago Bolívar'],
            ['nombre' => 'Alejandría',              'tipo_comunidad' => 'rural', 'municipio_id' => 19, 'latitud' => -12.4850, 'longitud' => -63.6800, 'direccion' => 'Comunidad Alejandría',              'referencia' => 'Nombre de inspiración histórica'],
            ['nombre' => 'Altura el Carmen',        'tipo_comunidad' => 'rural', 'municipio_id' => 19, 'latitud' => -12.5100, 'longitud' => -63.6500, 'direccion' => 'Comunidad Altura el Carmen',        'referencia' => 'Cerro alto con vista al lago'],
            ['nombre' => 'Santa Rosa del Vigo',     'tipo_comunidad' => 'rural', 'municipio_id' => 19, 'latitud' => -12.4950, 'longitud' => -63.6700, 'direccion' => 'Comunidad Santa Rosa del Vigo',     'referencia' => 'Virgen de Santa Rosa en la zona del Vigo'],
            ['nombre' => 'Puerto Siles',            'tipo_comunidad' => 'rural', 'municipio_id' => 19, 'latitud' => -12.5000, 'longitud' => -63.6667, 'direccion' => 'Comunidad Puerto Siles',            'referencia' => 'Cabecera municipal y puerto fluvial'],
        ];

$bar = $this->command->getOutput()->createProgressBar(count($comunidades));
        $bar->start();

        foreach ($comunidades as $comunidad) {
            if (!isset($comunidad['latitud'], $comunidad['longitud'], $comunidad['municipio_id'])) {
                $this->command->error("Error al crear la comunidad {$comunidad['nombre']}: Falta una de las claves 'latitud', 'longitud' o 'municipio_id'.");
                $bar->advance();
                continue;
            }

            // Verificar si ya existe la comunidad
            // $exists = DB::table('comunidades')->where('nombre', $comunidad['nombre'])->exists();
            // Usa:
            $exists = DB::table('comunidades')
                ->where('nombre', $comunidad['nombre'])
                ->where('municipio_id', $comunidad['municipio_id'])
                ->exists();
            if ($exists) {
                $this->command->warn("Comunidad {$comunidad['nombre']} ya existe, saltando...");
                $bar->advance();
                continue;
            }

            try {
                // Insertar la ubicación (usando ST_GeomFromText en lugar de ST_PointFromText)
                $ubicacionId = DB::table('ubicaciones')->insertGetId([
                    'direccion'   => $comunidad['direccion'],
                    'referencia'  => $comunidad['referencia'],
                    'coordenadas' => DB::raw("ST_GeomFromText('POINT(" . $comunidad['longitud'] . " " . $comunidad['latitud'] . ")', 4326)"),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                // Insertar la comunidad
                DB::table('comunidades')->insert([
                    'nombre'          => $comunidad['nombre'],
                    'tipo_comunidad'  => $comunidad['tipo_comunidad'],
                    'municipio_id'    => $comunidad['municipio_id'],
                    'ubicacion_id'    => $ubicacionId,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            } catch (\Exception $e) {
                Log::error("Error al crear la comunidad {$comunidad['nombre']}: " . $e->getMessage());
                $this->command->error("Error al crear la comunidad {$comunidad['nombre']}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\n" . count($comunidades) . ' comunidades han sido procesadas.');
    }
}
