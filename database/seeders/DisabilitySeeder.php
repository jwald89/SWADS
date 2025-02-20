<?php

namespace Database\Seeders;

use App\Models\Disability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Mental'
            ],
            [
                'description' => 'Deaf/ Hard of Hearing',
            ],
            [
                'description' => 'Psychosocial',
            ],
            [
                'description' => 'Visual',
            ],
            [
                'description' => 'Speech & Language impairment',
            ],
            [
                'description' => 'Learning',
            ],
            [
                'description' => 'Intellectual',
            ],
            [
                'description' => 'Physical (Orthopedic)',
            ],
            [
                'description' => 'Cancer (RA 12215)',
            ],
            [
                'description' => 'Rare Disease (RA 10747)',
            ],
            [
                'description' => 'Multiple Disability',
            ],
            [
                'description' => 'Development Disability',
            ],
        ];

        foreach($data as $key => $disability)
        {
            Disability::create($disability);
        }
    }
}
