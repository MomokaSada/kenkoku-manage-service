<?php

namespace Database\Seeders;

use Database\Seeders\NpcTypeSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            NpcTypeSeeder::class,
            BiomeSeeder::class,
            ProfessionSeeder::class,
        ]);
    }
}
