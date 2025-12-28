<?php

namespace App\Services;

use App\Models\Npc;
use App\Models\Trade;
use App\Models\TradeCosts;
use App\Models\Reward;

class NpcBulkServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store($dataList)
    {
        foreach ($dataList as $data) {
            $npcData = $data;
            unset($npcData['trades']);
            if (isset($npcData['type']) && !isset($npcData['npc_type_id'])) {
                $npcData['npc_type_id'] = $npcData['type'];
                unset($npcData['type']);
            }
            
            $npc = Npc::create($npcData);

            if (isset($data['trades'])) {
                foreach ($data['trades'] as $tradeData) {
                    $this->createTrade($npc, $tradeData);
                }
            }
        }
    }

    public function patch($dataList)
    {
        foreach ($dataList as $data) {
            $npc = Npc::find($data['id']);
            if (!$npc) continue;

            $npcData = $data;
            unset($npcData['trades']);
            if (isset($npcData['type']) && !isset($npcData['npc_type_id'])) {
                $npcData['npc_type_id'] = $npcData['type'];
                unset($npcData['type']);
            }

            $npc->update($npcData);

            if (isset($data['trades'])) {
                $this->syncTrades($npc, $data['trades']);
            }
        }
    }

    public function delete($ids)
    {
        Npc::destroy($ids);
    }

    private function createTrade($npc, $tradeData)
    {
        $tData = $tradeData;
        
        // Ensure content exists (default if missing)
        if (!isset($tData['content'])) {
            $tData['content'] = 'Trade'; 
        }

        if (array_key_exists('view_item_id', $tData) && empty($tData['view_item_id'])) {
            $tData['view_item_id'] = null;
        }

        unset($tData['rewards']);
        unset($tData['costs']); // Remove costs from trade data
        
        // Remove legacy cost fields if present to avoid errors, though strictly we expect 'costs'
        unset($tData['item_id']);
        unset($tData['quantity']);
        unset($tData['price']);

        $trade = $npc->trades()->create($tData);

        if (isset($tradeData['costs'])) {
            foreach ($tradeData['costs'] as $costData) {
                $trade->costs()->create($costData);
            }
        }

        if (isset($tradeData['rewards'])) {
            foreach ($tradeData['rewards'] as $rewardData) {
                $trade->rewards()->create($rewardData);
            }
        }
    }

    private function syncTrades($npc, $tradesData)
    {
        $receivedIds = array_filter(array_column($tradesData, 'id'));
        $npc->trades()->whereNotIn('id', $receivedIds)->delete();

        foreach ($tradesData as $tData) {
            if (isset($tData['id'])) {
                $trade = Trade::find($tData['id']);
                if ($trade && $trade->npc_id == $npc->id) {
                    $tradeFields = $tData;
                    
                    if (array_key_exists('view_item_id', $tradeFields) && empty($tradeFields['view_item_id'])) {
                        $tradeFields['view_item_id'] = null;
                    }
                    
                    unset($tradeFields['rewards']);
                    unset($tradeFields['costs']);
                    unset($tradeFields['item_id']);
                    unset($tradeFields['quantity']);
                    unset($tradeFields['price']);

                    $trade->update($tradeFields);

                    if (isset($tData['costs'])) {
                        $this->syncCosts($trade, $tData['costs']);
                    }

                    if (isset($tData['rewards'])) {
                        $this->syncRewards($trade, $tData['rewards']);
                    }
                }
            } else {
                $this->createTrade($npc, $tData);
            }
        }
    }

    private function syncCosts($trade, $costsData)
    {
        $receivedIds = array_filter(array_column($costsData, 'id'));
        $trade->costs()->whereNotIn('id', $receivedIds)->delete();

        foreach ($costsData as $cData) {
            if (isset($cData['id'])) {
                $cost = TradeCosts::find($cData['id']);
                if ($cost && $cost->trade_id == $trade->id) {
                    $cost->update($cData);
                }
            } else {
                $trade->costs()->create($cData);
            }
        }
    }

    private function syncRewards($trade, $rewardsData)
    {
        $receivedIds = array_filter(array_column($rewardsData, 'id'));
        $trade->rewards()->whereNotIn('id', $receivedIds)->delete();

        foreach ($rewardsData as $rData) {
            if (isset($rData['id'])) {
                $reward = Reward::find($rData['id']);
                if ($reward && $reward->trade_id == $trade->id) {
                    $reward->update($rData);
                }
            } else {
                $trade->rewards()->create($rData);
            }
        }
    }
}
