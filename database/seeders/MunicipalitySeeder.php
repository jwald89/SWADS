<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\Municipality;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Barobo' => [
                'barangay_list' => [
                    0 => 'Amaga',
                    1 => 'Bahi',
                    2 => 'Cabacungan',
                    3 => 'Cambagang',
                    4 => 'Causwagan',
                    5 => 'Dapdap',
                    6 => 'Dughan',
                    7 => 'Gamut',
                    8 => 'Javier',
                    9 => 'Kinayan',
                    10 => 'Mamis',
                    11 => 'Poblacion',
                    12 => 'Rizal',
                    13 => 'San Jose',
                    14 => 'San Roque',
                    15 => 'San Vicente',
                    16 => 'Sua',
                    17 => 'Sudlon',
                    18 => 'Tambis',
                    19 => 'Unidad',
                    20 => 'Wakat',
                ],
            ],
            'Bayabas' => [
                'barangay_list' => [
                    0 => 'Amag',
                    1 => 'Balete (Pob.)',
                    2 => 'Cabugo',
                    3 => 'Cagbaoto',
                    4 => 'La Paz',
                    5 => 'Magobawok',
                    6 => 'Panaosawon',
                ],
            ],
            'Bislig City' => [
                'barangay_list' => [
                    0 => 'Bucto',
                    1 => 'Burboanan',
                    2 => 'Caguyao',
                    3 => 'Coleto',
                    4 => 'Comawas',
                    5 => 'Kahayag',
                    6 => 'Labisma',
                    7 => 'Lawigan',
                    8 => 'Maharlika',
                    9 => 'Mangagoy',
                    10 => 'Mone',
                    11 => 'Pamanlinan',
                    12 => 'Pamaypayan',
                    13 => 'Poblacion',
                    14 => 'San Antonio',
                    15 => 'San Fernando',
                    16 => 'San Isidro (Bagnan)',
                    17 => 'San Jose',
                    18 => 'San Roque (Cadanglasan)',
                    19 => 'San Vicente',
                    20 => 'Santa Cruz',
                    21 => 'Sibaroy',
                    22 => 'Tabon',
                    23 => 'Tumanan',
                ],
            ],
            'Cagwait' => [
                'barangay_list' => [
                    0 => 'Aras-Asan',
                    1 => 'Bacolod',
                    2 => 'Bitaugan East',
                    3 => 'Bitaugan West',
                    4 => 'La Purisima (Palhe)',
                    5 => 'Lactudan',
                    6 => 'Mat-e',
                    7 => 'Poblacion',
                    8 => 'Tawagan',
                    9 => 'Tubo-Tubo',
                    10 => 'Unidad',
                ],
            ],
            'Cantilan' => [
                'barangay_list' => [
                    0 => 'Bugsukan',
                    1 => 'Buntalid',
                    2 => 'Cabangahan',
                    3 => 'Cabas-an',
                    4 => 'Calagdaan',
                    5 => 'Consuelo',
                    6 => 'General Island',
                    7 => 'Lininti-an (Pob.)',
                    8 => 'Lobo',
                    9 => 'Magasang',
                    10 => 'Magosilom (Pob.)',
                    11 => 'Pag-Antayan',
                    12 => 'Palasao',
                    13 => 'Parang',
                    14 => 'San Pedro',
                    15 => 'Tapi',
                    16 => 'Tigabong',
                ],
            ],
            'Carmen' => [
                'barangay_list' => [
                    0 => 'Antao',
                    1 => 'Cancavan',
                    2 => 'Carmen (Pob.)',
                    3 => 'Esperanza',
                    4 => 'Hinapoyan',
                    5 => 'Puyat',
                    6 => 'San Vicente',
                    7 => 'Santa Cruz',
                ],
            ],
            'Carrascal' => [
                'barangay_list' => [
                    0 => 'Adlay',
                    1 => 'Babuyan',
                    2 => 'Bacolod',
                    3 => 'Baybay (Pob.)',
                    4 => 'Bon-ot',
                    5 => 'Caglayag',
                    6 => 'Dahican',
                    7 => 'Doyos (Pob.)',
                    8 => 'Embarcadero (Pob.)',
                    9 => 'Gamuton',
                    10 => 'Panikian',
                    11 => 'Pantukan',
                    12 => 'Saca (Pob.)',
                    13 => 'Tag-Anito',
                ],
            ],
            'Cortes' => [
                'barangay_list' => [
                    0 => 'Balibadon',
                    1 => 'Burgos',
                    2 => 'Capandan',
                    3 => 'Mabahin',
                    4 => 'Madrelino',
                    5 => 'Manlico',
                    6 => 'Matho',
                    7 => 'Poblacion',
                    8 => 'Tag-Anongan',
                    9 => 'Tigao',
                    10 => 'Tuboran',
                    11 => 'Uba',
                ],
            ],
            'Hinatuan' => [
                'barangay_list' => [
                    0 => 'Baculin',
                    1 => 'Benigno Aquino (Zone I) Pob.',
                    2 => 'Bigaan',
                    3 => 'Cambatong',
                    4 => 'Campa',
                    5 => 'Dugmanon',
                    6 => 'Harip',
                    7 => 'La Casa (Pob.)',
                    8 => 'Loyola',
                    9 => 'Maligaya',
                    10 => 'Pagtigni-an (Bitoon)',
                    11 => 'Pocto',
                    12 => 'Port Lamon',
                    13 => 'Roxas',
                    14 => 'San Juan',
                    15 => 'Sasa',
                    16 => 'Tagasaka',
                    17 => 'Tagbobonga',
                    18 => 'Talisay',
                    19 => 'Tarusan',
                    20 => 'Tidman',
                    21 => 'Tiwi',
                    22 => 'Zone II (Pob.)',
                    23 => 'Zone III Maharlika (Pob.)',
                ],
            ],
            'Lanuza' => [
                'barangay_list' => [
                    0 => 'Agsam',
                    1 => 'Bocawe',
                    2 => 'Bunga',
                    3 => 'Gamuton',
                    4 => 'Habag',
                    5 => 'Mampi',
                    6 => 'Nurcia',
                    7 => 'Pakwan',
                    8 => 'Sibahay',
                    9 => 'Zone I (Pob.)',
                    10 => 'Zone II (Pob.)',
                    11 => 'Zone III (Pob.)',
                    12 => 'Zone IV (Pob.)',
                ],
            ],
            'Lianga' => [
                'barangay_list' => [
                    0 => 'Anibongan',
                    1 => 'Ban-as',
                    2 => 'Banahao',
                    3 => 'Baucawe',
                    4 => 'Diatagon',
                    5 => 'Ganayon',
                    6 => 'Liatimco',
                    7 => 'Manyayay',
                    8 => 'Payasan',
                    9 => 'Poblacion',
                    10 => 'Saint Christine',
                    11 => 'San Isidro',
                    12 => 'San Pedro',
                ],
            ],
            'Lingig' => [
                'barangay_list' => [
                    0 => 'Anibongan',
                    1 => 'Barcelona',
                    2 => 'Bogak',
                    3 => 'Bongan',
                    4 => 'Handamayan',
                    5 => 'Mahayahay',
                    6 => 'Mandus',
                    7 => 'Mansa-Ilao',
                    8 => 'Pagtila-an',
                    9 => 'Palo Alto',
                    10 => 'Poblacion',
                    11 => 'Rajah Cabungso-an',
                    12 => 'Sabang',
                    13 => 'Salvacion',
                    14 => 'San Roque',
                    15 => 'Tagpoporan',
                    16 => 'Union',
                    17 => 'Valencia',
                ],
            ],
            'Madrid' => [
                'barangay_list' => [
                    0 => 'Bagsac',
                    1 => 'Bayogo',
                    2 => 'Linibonan',
                    3 => 'Magsaysay',
                    4 => 'Manga',
                    5 => 'Panayogon',
                    6 => 'Patong Patong',
                    7 => 'Quirino (Pob.)',
                    8 => 'San Antonio',
                    9 => 'San Juan',
                    10 => 'San Roque',
                    11 => 'San Vicente',
                    12 => 'Songkit',
                    13 => 'Union',
                ],
            ],
            'Marihatag' => [
                'barangay_list' => [
                    0 => 'Alegria',
                    1 => 'Amontay',
                    2 => 'Antipolo',
                    3 => 'Arorogan',
                    4 => 'Bayan',
                    5 => 'Mahaba',
                    6 => 'Mararag',
                    7 => 'Poblacion',
                    8 => 'San Antonio',
                    9 => 'San Isidro',
                    10 => 'San Pedro',
                    11 => 'Santa Cruz',
                ],
            ],
            'San Agustin' => [
                'barangay_list' => [
                    0 => 'Bretania',
                    1 => 'Buatong',
                    2 => 'Buhisan',
                    3 => 'Gata',
                    4 => 'Hornasan',
                    5 => 'Janipaan',
                    6 => 'Kauswagan',
                    7 => 'Oteiza',
                    8 => 'Poblacion',
                    9 => 'Pong-on',
                    10 => 'Pongtod',
                    11 => 'Salvacion',
                    12 => 'Santo Niño',
                ],
            ],
            'San Miguel' => [
                'barangay_list' => [
                    0 => 'Bagyang',
                    1 => 'Baras',
                    2 => 'Bitaugan',
                    3 => 'Bolhoon',
                    4 => 'Calatngan',
                    5 => 'Carromata',
                    6 => 'Castillo',
                    7 => 'Libas Gua',
                    8 => 'Libas Sud',
                    9 => 'Magroyong',
                    10 => 'Mahayag (Maitum)',
                    11 => 'Patong',
                    12 => 'Poblacion',
                    13 => 'Sagbayan',
                    14 => 'San Roque',
                    15 => 'Siagao',
                    16 => 'Tina',
                    17 => 'Umalag',
                ],
            ],
            'Tagbina' => [
                'barangay_list' => [
                    0 => 'Batunan',
                    1 => 'Carpenito',
                    2 => 'Doña Carmen',
                    3 => 'Hinagdanan',
                    4 => 'Kahayagan',
                    5 => 'Lago',
                    6 => 'Maglambing',
                    7 => 'Maglatab',
                    8 => 'Magsaysay',
                    9 => 'Malixi',
                    10 => 'Manambia',
                    11 => 'Osmeña',
                    12 => 'Poblacion',
                    13 => 'Quezon',
                    14 => 'San Vicente',
                    15 => 'Santa Cruz',
                    16 => 'Santa Fe',
                    17 => 'Santa Juana',
                    18 => 'Santa Maria',
                    19 => 'Sayon',
                    20 => 'Soriano',
                    21 => 'Tagongon',
                    22 => 'Trinidad',
                    23 => 'Ugoban',
                    24 => 'Villaverde',
                ],
            ],
            'Tago' => [
                'barangay_list' => [
                    0 => 'Alba',
                    1 => 'Anahao Bag-o',
                    2 => 'Anahao Daan',
                    3 => 'Badong',
                    4 => 'Bajao',
                    5 => 'Bangsud',
                    6 => 'Cabangahan',
                    7 => 'Cagdapao',
                    8 => 'Camagong',
                    9 => 'Caras-an',
                    10 => 'Cayale',
                    11 => 'Dayo-an',
                    12 => 'Gamut',
                    13 => 'Jubang',
                    14 => 'Kinabigtasan',
                    15 => 'Layog',
                    16 => 'Lindoy',
                    17 => 'Mercedes',
                    18 => 'Purisima (Pob.)',
                    19 => 'Sumo-Sumo',
                    20 => 'Umbay',
                    21 => 'Unaban',
                    22 => 'Unidos',
                    23 => 'Victoria',
                ],
            ],
            'Tandag City' => [
                'barangay_list' => [
                    0 => 'Awasian',
                    1 => 'Bagong Lungsod (Pob.)',
                    2 => 'Bioto',
                    3 => 'Bongtod Pob. (East West)',
                    4 => 'Buenavista',
                    5 => 'Dagocdoc (Pob.)',
                    6 => 'Mabua',
                    7 => 'Mabuhay',
                    8 => 'Maitum',
                    9 => 'Maticdum',
                    10 => 'Pandanon',
                    11 => 'Pangi',
                    12 => 'Quezon',
                    13 => 'Rosario',
                    14 => 'Salvacion',
                    15 => 'San Agustin Norte',
                    16 => 'San Agustin Sur',
                    17 => 'San Antonio',
                    18 => 'San Isidro',
                    19 => 'San Jose',
                    20 => 'Telaje',
                ],
            ],
        ];

        foreach($data as $municipality => $records) {
            $m = Municipality::create([
                'municipality' => $municipality,
            ]);


            foreach($records['barangay_list'] as $barangay) {
                Barangay::create([
                    'municipality_id' => $m->id,
                    'barangay' => $barangay,
                ]);
            }


        }
    }
}
