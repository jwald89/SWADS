<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\IndigentPeople;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            MunicipalitySeeder::class,
            UserSeeder::class,
            AssistanceTypeSeeder::class,
            SectorSeeder::class,
            OfficeChargeSeeder::class,
            IndigentSeeder::class,
            ClassificationSeeder::class,
            DisabilitySeeder::class,
        ]);
    }
}
