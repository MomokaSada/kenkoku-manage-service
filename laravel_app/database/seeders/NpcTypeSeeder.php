<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NpcTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'pawnshop'],
            ['name' => 'shop'],
            ['name' => 'quest'],
        ];
        DB::table('npc_types')->insert($types);
    }
}
