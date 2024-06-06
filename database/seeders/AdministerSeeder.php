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
                'fullname' => 'Sheila T. Arizobal'
            ],
            [
                'fullname' => 'Junie A. Bapor, Jr.'
            ],
            [
                'fullname' => 'Pia B. Curada'
            ],
            [
                'fullname' => 'Jimmy N. De Julian'
            ],
            [
                'fullname' => 'Maria Paula S. Gallardo'
            ],
            [
                'fullname' => 'Bryan P. Mojica'
            ],
            [
                'fullname' => 'Paul D. Solis'
            ],
        ];

        foreach($data as $key => $admin)
        {
            StaffAdministered::create($admin);
        }
    }
}
