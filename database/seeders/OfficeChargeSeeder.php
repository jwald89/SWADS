<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OfficeChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'PGO',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
            [
                'description' => 'PVGO',
                'first_name' => 'Manuel',
                'middle_name' => 'Osorio',
                'last_name' => 'Alameda',
                'title' => 'Provincial Vice-Governor'
            ],
            [
                'description' => 'SB',
                'first_name' => 'NA',
                'middle_name' => '',
                'last_name' => 'NA',
                'title' => 'NA'
            ],
            [
                'description' => 'SP',
                'first_name' => 'NA',
                'middle_name' => '',
                'last_name' => 'NA',
                'title' => 'NA'
            ],
            [
                'description' => 'CWS',
                'first_name' => 'NA',
                'middle_name' => '',
                'last_name' => 'NA',
                'title' => 'NA'
            ],
            [
                'description' => 'PSWDO',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
            [
                'description' => 'PSWDO (Disaster)',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
            [
                'description' => 'PSWDO (Senior Citizen)',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
            [
                'description' => 'PSWDO (PWD)',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
            [
                'description' => 'PSWDO (Children)',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
            [
                'description' => 'PSWDO (GAD)',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
            [
                'description' => 'PSWDO (E-CLIP)',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
            [
                'description' => 'PSWDO (Mentally ill)',
                'first_name' => 'Alexander',
                'middle_name' => 'Ty',
                'last_name' => 'Pimentel',
                'title' => 'Provincial Governor'
            ],
        ];

        foreach($data as $key => $sector)
        {
            Office::create($sector);
        }
    }
}
