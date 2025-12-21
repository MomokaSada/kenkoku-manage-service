<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Jobs\ItemNameMergeJob;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('key', 'like', '%' . $request->search . '%');
        })
            ->orderBy('key', 'asc')
            ->get();
        return response()->json($items);
    }

    public function update(Request $request)
    {
        // リクエストからバージョンを取得、なければデフォルト値など
        $version = $request->input('minecraft_version', '1.21.11'); // デフォルト値は適宜変更
        ItemNameMergeJob::dispatch($version);
        return response()->json([
            'message' => 'アイテム名の更新を開始しました',
        ]);
    }
}
