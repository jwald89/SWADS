<?php

namespace Database\Seeders;

use App\Models\StaffAdministered;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'lastname' => 'Arizobal',
                'firstname' => 'Sheila',
                'middlename' => 'T.'
            ],
            [
                'lastname' => 'Bapor, Jr.',
                'firstname' => 'Junie',
                'middlename' => 'A.'
            ],
            [
                'lastname' => 'Curada',
                'firstname' => 'Pia',
                'middlename' => 'B.'
            ],
            [
                'lastname' => 'De Julian',
                'firstname' => 'Jimmy',
                'middlename' => 'N.',
            ],
            [
                'lastname' => 'Gallardo',
                'firstname' => 'Maria Paula',
                'middlename' => 'S.',
            ],
            [
                'lastname' => 'Mojica',
                'firstname' => 'Bryan',
                'middlename' => 'P.',
            ],
            [
                'lastname' => 'Solis',
                'firstname' => 'Paul',
                'middlename' => 'D.',
            ],
        ];

        foreach($data as $key => $admin)
        {
            StaffAdministered::create($admin);
        }
    }
}
