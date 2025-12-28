<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LotterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Load JSON data
        $jsonPath = base_path('lottery_demo_data_original.json');
        if (!File::exists($jsonPath)) {
            $this->command->error("File not found: $jsonPath");
            return;
        }

        $data = json_decode(File::get($jsonPath), true);
        if (!$data) {
            $this->command->error("Invalid JSON data in $jsonPath");
            return;
        }

        // 2. Clear existing data (Disable FK checks to truncate freely)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lottery_items')->truncate();
        DB::table('rarities')->truncate();
        DB::table('lotteries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Process each lottery
        foreach ($data as $lotteryData) {
            $lotteryId = DB::table('lotteries')->insertGetId([
                'name' => $lotteryData['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("Created Lottery: {$lotteryData['name']}");

            foreach ($lotteryData['rarities'] as $rarityData) {
                $rarityId = DB::table('rarities')->insertGetId([
                    'lottery_id' => $lotteryId,
                    'name' => $rarityData['name'],
                    'probability' => $rarityData['probability'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($rarityData['items'] as $itemData) {
                    // 4. Dynamic Item ID Lookup
                    // Determine search criteria based on 'is_original' flag
                    // usage in JSON: "key": "wallet" (which is the unique name/key in seed-items)
                    // The 'items' table has `key` (base minecraft id) and `name` (unique identifier for custom items).
                    
                    $query = DB::table('items');

                    if (isset($itemData['is_original']) && $itemData['is_original'] === true) {
                        // For original items, we look up by `name` (unique_name) column in DB
                        // In JSON, 'key' holds the unique name like 'health_boost_1'
                        $query->where('name', $itemData['key'])
                              ->where('is_original', true);
                    } else {
                        // For vanilla items, we look up by `key` (minecraft id) column
                        // In JSON, 'key' holds 'minecraft:apple'
                        $query->where('key', $itemData['key'])
                              ->where('is_original', false);
                    }

                    $itemRecord = $query->first();

                    if (!$itemRecord) {
                        // If item not found, try to auto-insert vanilla item if it's not original
                        if ((!isset($itemData['is_original']) || $itemData['is_original'] === false) && str_starts_with($itemData['key'], 'minecraft:')) {
                            $itemId = DB::table('items')->insertGetId([
                                'key' => $itemData['key'],
                                'name' => $itemData['name'], 
                                'is_original' => false,
                                'nbt' => '{}', // Default empty NBT
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            $this->command->warn("  Auto-created missing vanilla item: {$itemData['key']}");
                        } else {
                            $this->command->error("  Item not found in DB: {$itemData['key']} (Original: " . ($itemData['is_original'] ? 'Yes' : 'No') . ")");
                            continue;
                        }
                    } else {
                        $itemId = $itemRecord->id;
                    }

                    // Insert into lottery_items
                    DB::table('lottery_items')->insert([
                        'lottery_id' => $lotteryId,
                        'item_id' => $itemId,
                        'rarity_id' => $rarityId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        $this->command->info("Lottery seeding completed successfully.");
    }
}
