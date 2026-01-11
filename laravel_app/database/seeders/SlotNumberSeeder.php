<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Npc;

class SlotNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Npc::all()->each(function ($npc) {
            $count = 0;
            $npc->trades()->each(function ($trade) use (&$count) {
                $trade->update([
                    'slot' => $count,
                ]);
                $count++;
            });
        });
    }
}
