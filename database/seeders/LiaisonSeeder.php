<?php

namespace Database\Seeders;

use App\Models\Liaison;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LiaisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'lastname' => 'Laurente',
                'firstname' => 'Sheila Ann',
                'middlename' => 'G.'
            ],
            [
                'lastname' => 'Pangilinan',
                'firstname' => 'Haide',
                'middlename' => ''
            ],
            [
                'lastname' => 'Umali',
                'firstname' => 'Mary Jane',
                'middlename' => ''
            ],
        ];

        foreach($data as $key => $liaison)
        {
            Liaison::create($liaison);
        }
    }
}
