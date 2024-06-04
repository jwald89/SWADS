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
            ],
            [
                'name' => 'Burial',
            ],
            [
                'name' => 'Educational',
            ],
            [
                'name' => 'Financial',
            ],
            [
                'name' => 'Livelihood',
            ],
            [
                'name' => 'Transportation',
            ],
            [
                'name' => 'Financial/ Solo Parent',
            ],
            [
                'name' => 'Financial/ Mentally ill',
            ],
            [
                'name' => 'Financial/ Special Case',
            ],
            [
                'name' => 'Financial/ Repatriated',
            ],
            [
                'name' => 'Financial/ VAWC',
            ],
        ];

        foreach($data as $key => $assistance)
        {
            AssistanceType::create($assistance);
        }
    }
}
