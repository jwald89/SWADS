<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Men'
            ],
            [
                'name' => 'Women',
            ],
            [
                'name' => 'Youth',
            ],
            [
                'name' => 'Children',
            ],
            [
                'name' => 'Senior Citizen',
            ],
            [
                'name' => 'PWD',
            ],
            [
                'name' => 'Solo Parent',
            ],
            [
                'name' => 'Former Rebel',
            ],
        ];

        foreach($data as $key => $sector)
        {
            Sector::create($sector);
        }
    }
}
