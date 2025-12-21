<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    public function run(): void
    {
        $professions = [
            ['key' => 'none'],
            ['key' => 'armorer'],
            ['key' => 'butcher'],
            ['key' => 'cartographer'],
            ['key' => 'cleric'],
            ['key' => 'farmer'],
            ['key' => 'fisherman'],
            ['key' => 'fletcher'],
            ['key' => 'leatherworker'],
            ['key' => 'librarian'],
            ['key' => 'mason'],
            ['key' => 'nitwit'],
            ['key' => 'shepherd'],
            ['key' => 'toolsmith'],
            ['key' => 'weaponsmith'],
        ];

        foreach ($professions as $prof) {
            DB::table('professions')->updateOrInsert(
                ['key' => $prof['key']]
            );
        }
    }
}
