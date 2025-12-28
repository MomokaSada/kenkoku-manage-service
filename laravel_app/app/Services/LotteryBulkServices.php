<?php

namespace App\Services;

class LotteryBulkServices
{
    /**
     * Create a new class instance.
     */
    public function store($dataList)
    {
        foreach ($dataList as $data) {
            $lotteryData = $data;
            unset($lotteryData['rarities']);
            
            $lottery = \App\Models\Lottery::create($lotteryData);

            if (isset($data['rarities'])) {
                foreach ($data['rarities'] as $rarityData) {
                    $rarityFields = $rarityData;
                    unset($rarityFields['items']);

                    $rarity = $lottery->rarities()->create($rarityFields);

                    if (isset($rarityData['items'])) {
                        foreach ($rarityData['items'] as $itemId) {
                            $rarity->lotteryItems()->create([
                                'lottery_id' => $lottery->id,
                                'item_id' => $itemId
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function patch($dataList)
    {
        foreach ($dataList as $data) {
            $lottery = \App\Models\Lottery::find($data['id']);
            if (!$lottery) continue;

            $lotteryData = $data;
            unset($lotteryData['rarities']);

            $lottery->update($lotteryData);

            if (isset($data['rarities'])) {
                $this->syncRarities($lottery, $data['rarities']);
            }
        }
    }

    public function delete($ids)
    {
        \App\Models\Lottery::destroy($ids);
    }

    private function syncRarities($lottery, $raritiesData)
    {
        $receivedIds = array_filter(array_column($raritiesData, 'id'));
        $lottery->rarities()->whereNotIn('id', $receivedIds)->delete();

        foreach ($raritiesData as $rData) {
            if (isset($rData['id'])) {
                $rarity = \App\Models\Rarity::find($rData['id']);
                if ($rarity && $rarity->lottery_id == $lottery->id) {
                    $rarityFields = $rData;
                    unset($rarityFields['items']);
                    $rarity->update($rarityFields);

                    if (isset($rData['items'])) {
                        $this->syncItems($lottery, $rarity, $rData['items']);
                    }
                }
            } else {
                $rarityFields = $rData;
                unset($rarityFields['items']);
                $rarity = $lottery->rarities()->create($rarityFields);

                if (isset($rData['items'])) {
                    foreach ($rData['items'] as $itemId) {
                        $rarity->lotteryItems()->create([
                            'lottery_id' => $lottery->id,
                            'item_id' => $itemId
                        ]);
                    }
                }
            }
        }
    }

    private function syncItems($lottery, $rarity, $itemsIds)
    {
        // Delete items that are not in the new list
        $rarity->lotteryItems()->whereNotIn('item_id', $itemsIds)->delete();

        // Get existing item_ids to avoid duplicates if necessary, or just check existence
        $existingItemIds = $rarity->lotteryItems()->pluck('item_id')->toArray();

        foreach ($itemsIds as $itemId) {
             if (!in_array($itemId, $existingItemIds)) {
                 $rarity->lotteryItems()->create([
                     'lottery_id' => $lottery->id,
                     'item_id' => $itemId
                 ]);
             }
        }
    }
}
