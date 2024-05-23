<?php

namespace Database\Seeders;

use App\Models\AssistanceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssistanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Medical',
                'sub_name' => '',
            ],
            [
                'name' => 'Burial',
                'sub_name' => '',
            ],
            [
                'name' => 'Educational',
                'sub_name' => ''
            ],
            [
                'name' => 'Financial',
                'sub_name' => ''
            ],
            [
                'name' => 'Livelihood',
                'sub_name' => ''
            ],
            [
                'name' => 'Transportation',
                'sub_name' => ''
            ],
            [
                'name' => 'Financial',
                'sub_name' => 'Solo Parent'
            ],
            [
                'name' => 'Financial',
                'sub_name' => 'Mentally ill'
            ],
            [
                'name' => 'Financial',
                'sub_name' => 'Special Case'
            ],
            [
                'name' => 'Financial',
                'sub_name' => 'Repatriated'
            ],
            [
                'name' => 'Financial',
                'sub_name' => 'VAWC'
            ],
        ];

        foreach($data as $key => $assistance)
        {
            AssistanceType::create($assistance);
        }
    }
}
