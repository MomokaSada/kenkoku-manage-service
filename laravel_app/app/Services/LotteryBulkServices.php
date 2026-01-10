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
                        foreach ($rarityData['items'] as $itemData) {
                            $itemId = is_array($itemData) ? $itemData['item_id'] : $itemData;
                            $quantity = is_array($itemData) ? ($itemData['quantity'] ?? 1) : 1;

                            $rarity->lotteryItems()->create([
                                'lottery_id' => $lottery->id,
                                'item_id' => $itemId,
                                'quantity' => $quantity,
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
                    foreach ($rData['items'] as $itemData) {
                        $itemId = is_array($itemData) ? $itemData['item_id'] : $itemData;
                        $quantity = is_array($itemData) ? ($itemData['quantity'] ?? 1) : 1;

                        $rarity->lotteryItems()->create([
                            'lottery_id' => $lottery->id,
                            'item_id' => $itemId,
                            'quantity' => $quantity,
                        ]);
                    }
                }
            }
        }
    }

    private function syncItems($lottery, $rarity, $itemsData)
    {
        // Normalize input: itemId => quantity
        $targetItems = [];
        foreach ($itemsData as $item) {
            if (is_array($item)) {
                $targetItems[$item['item_id']] = $item['quantity'] ?? 1;
            } else {
                $targetItems[$item] = 1;
            }
        }
        $targetIds = array_keys($targetItems);

        // Delete items that are not in the new list
        $rarity->lotteryItems()->whereNotIn('item_id', $targetIds)->delete();

        // Update existing or create new
        foreach ($targetItems as $itemId => $quantity) {
            $lotteryItem = $rarity->lotteryItems()->where('item_id', $itemId)->first();

            if ($lotteryItem) {
                if ($lotteryItem->quantity != $quantity) {
                    $lotteryItem->update(['quantity' => $quantity]);
                }
            } else {
                $rarity->lotteryItems()->create([
                    'lottery_id' => $lottery->id,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                ]);
            }
        }
    }
}
