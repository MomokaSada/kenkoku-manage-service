<?php

namespace App\Http\Controllers;

use App\Models\Npc;
use App\Models\Trade;
use App\Models\Reward;
use App\Models\Biome;
use App\Models\Profession;
use App\Services\NpcBulkServices;
use App\Http\Requests\NpcBulkSaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NpcController extends Controller
{
    public function index(Request $request)
    {
        $npcs = Npc::with(['npcType', 'biome', 'profession', 'trades.rewards', 'trades.costs.item', 'trades.rewards.item'])
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

    public function bulkSave(NpcBulkSaveRequest $request, NpcBulkServices $npcBulkServices)
    {
        $requestStore = $request->store;
        $requestPatch = $request->patch;
        $requestDelete = $request->delete;

        DB::transaction(function () use ($requestStore, $requestPatch, $requestDelete, $npcBulkServices) {
            if ($requestDelete) {
                $npcBulkServices->delete($requestDelete);
            }

            if ($requestStore) {
                $npcBulkServices->store($requestStore);
            }

            if ($requestPatch) {
                $npcBulkServices->patch($requestPatch);
            }
        });
        return response()->json([
            'message' => 'success',
        ]);
    }
}
