<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BiomeSeeder extends Seeder
{
    public function run(): void
    {
        $biomes = [
            ['key' => 'plains'],
            ['key' => 'desert'],
            ['key' => 'savanna'],
            ['key' => 'snowy'],
            ['key' => 'taiga'],
            ['key' => 'swamp'],
            ['key' => 'jungle'],
        ];
        
        // Upsert to avoid duplicates
        foreach ($biomes as $biome) {
            DB::table('biomes')->updateOrInsert(
                ['key' => $biome['key']]
            );
        }
    }
}
