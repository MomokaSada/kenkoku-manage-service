<?php

namespace App\Http\Controllers;

use App\Models\Npc;
use App\Models\Trade;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NpcController extends Controller
{
    public function index(Request $request)
    {
        $npcs = Npc::with(['npcType', 'biome', 'profession', 'trades.rewards', 'trades.item', 'trades.rewards.item'])
            ->when($request->type, function ($query) use ($request) {
                return $query->where('npc_type_id', $request->type);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($npcs);
    }
    public function biomes(Request $request)
    {
        $biomes = Biome::all();
        return response()->json($biomes);
    }
    public function professions(Request $request)
    {
        $professions = Profession::all();
        return response()->json($professions);
    }

    public function bulkSave(Request $request)
    {
        $requestStore = $request->store;
        $requestPatch = $request->patch;
        $requestDelete = $request->delete;

        DB::transaction(function () use ($requestStore, $requestPatch, $requestDelete) {
            if ($requestDelete) {
                Npc::destroy($requestDelete);
            }

            if ($requestStore) {
                foreach ($requestStore as $data) {
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

            if ($requestPatch) {
                foreach ($requestPatch as $data) {
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
        });
    }

    private function createTrade($npc, $tradeData)
    {
        $tData = $tradeData;
        unset($tData['rewards']);
        $trade = $npc->trades()->create($tData);

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
                    unset($tradeFields['rewards']);
                    $trade->update($tradeFields);

                    if (isset($tData['rewards'])) {
                        $this->syncRewards($trade, $tData['rewards']);
                    }
                }
            } else {
                $this->createTrade($npc, $tData);
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
