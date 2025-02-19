<?php

namespace Database\Seeders;

use App\Models\IndigentPeople;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndigentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Banwaon'
            ],
            [
                'name' => 'Higaonon',
            ],
            [
                'name' => 'Mamanwa',
            ],
            [
                'name' => 'Mandaya',
            ],
            [
                'name' => 'Manobo',
            ],
        ];

        foreach($data as $key => $sector)
        {
            IndigentPeople::create($sector);
        }
    }
}
