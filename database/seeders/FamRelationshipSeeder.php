<?php

namespace Database\Seeders;

use App\Models\FamRelationship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamRelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Grandfather'
            ],
            [
                'name' => 'Grandmother',
            ],
            [
                'name' => 'Grandparent',
            ],
            [
                'name' => 'Grandson',
            ],
            [
                'name' => 'Father',
            ],
            [
                'name' => 'Mother',
            ],
            [
                'name' => 'Father-in-law',
            ],
            [
                'name' => 'Mother-in-law',
            ],
            [
                'name' => 'Husband',
            ],
            [
                'name' => 'Wife',
            ],
            [
                'name' => 'Uncle',
            ],
            [
                'name' => 'Aunt',
            ],
            [
                'name' => 'Sibling',
            ],
            [
                'name' => 'Brother',
            ],
            [
                'name' => 'Sister',
            ],
            [
                'name' => 'Cousin',
            ],
            [
                'name' => 'Son',
            ],
            [
                'name' => 'Daughter',
            ],
            [
                'name' => 'Nephew',
            ],
            [
                'name' => 'Niece',
            ],
        ];

        foreach($data as $key => $relationship)
        {
            FamRelationship::create($relationship);
        }
    }
}
