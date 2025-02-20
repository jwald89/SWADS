<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Non-4Ps'
            ],
            [
                'name' => '4Ps',
            ],
            [
                'name' => 'IPs',
            ],
        ];

        foreach($data as $key => $classification)
        {
            Classification::create($classification);
        }
    }
}
