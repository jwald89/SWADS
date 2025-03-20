<?php

namespace Database\Seeders;

use App\Models\Municipality;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'municipality' => Municipality::get()->random()->id,
            'first_name' => 'John',
            'middle_init' => 'S',
            'last_name' => 'Doe',
            'username' => 'admin',
            'title' => '',
            'designation' => 'IT Officer',
            'role_type' => 'ADMIN',
            'password' => bcrypt('password')
        ]);
    }
}
