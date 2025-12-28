<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\LotteryBulkServices;
use Illuminate\Support\Facades\DB;

class LotteryController extends Controller
{
    public function index(Request $request)
    {
        $lotteries = \App\Models\Lottery::with(['rarities.lotteryItems.item'])->get();
        return response()->json($lotteries);
    }
    public function bulkSave(Request $request, LotteryBulkServices $lotteryBulkServices)
    {
        $requestStore = $request->store;
        $requestPatch = $request->patch;
        $requestDelete = $request->delete;

        DB::transaction(function () use ($requestStore, $requestPatch, $requestDelete, $lotteryBulkServices) {
            if ($requestDelete) {
                $lotteryBulkServices->delete($requestDelete);
            }

            if ($requestStore) {
                $lotteryBulkServices->store($requestStore);
            }

            if ($requestPatch) {
                $lotteryBulkServices->patch($requestPatch);
            }
        });
        return response()->json([
            'message' => 'success',
        ]);
    }
}
