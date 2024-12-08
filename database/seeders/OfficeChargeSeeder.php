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
                'description' => 'PGO'
            ],
            [
                'description' => 'PVGO',
            ],
            [
                'description' => 'SB',
            ],
            [
                'description' => 'SP',
            ],
            [
                'description' => 'CWS',
            ],
            [
                'description' => 'PSWDO',
            ],
            [
                'description' => 'PSWDO (Disaster)',
            ],
            [
                'description' => 'PSWDO (Senior Citizen)',
            ],
            [
                'description' => 'PSWDO (PWD)',
            ],
            [
                'description' => 'PSWDO (Children)',
            ],
            [
                'description' => 'PSWDO (GAD)',
            ],
            [
                'description' => 'PSWDO (E-CLIP)',
            ],
            [
                'description' => 'PSWDO (Mentally ill)',
            ],
        ];

        foreach($data as $key => $sector)
        {
            Office::create($sector);
        }
    }
}
