<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ItemNameGetService
{
    /**
     * Minecraftの言語ファイルから日本語名を取得してDBを更新する
     *
     * @param string $minecraftVersion 例: "1.21.11"
     */
    public function execute(string $minecraftVersion)
    {
        // GitHubから言語ファイルを取得
        // バージョンコードがディレクトリ名と異なる場合がある（例: 1.21.1 -> 1.21）が、
        // ユーザーが指定したバージョンを信じるか、あるいは固定のメジャーバージョンを使う運用を想定
        $url = "https://raw.githubusercontent.com/InventivetalentDev/minecraft-assets/{$minecraftVersion}/assets/minecraft/lang/ja_jp.json";
        
        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("言語ファイルの取得に失敗しました: {$url} (Status: {$response->status()})");
        }

        $jaJpJson = $response->json();
        if (!$jaJpJson) {
            throw new \Exception("JSONのパースに失敗しました");
        }

        // バニラアイテムのみ対象
        $items = Item::where('is_original', false)->get();

        foreach ($items as $item) {
            // DBのキー例: "minecraft:stone", "minecraft:diamond_sword"
            $key = $item->key;
            
            // コロンがない場合はスキップ（異常データ）
            if (!str_contains($key, ':')) {
                continue;
            }

            list($namespace, $id) = explode(':', $key, 2);

            // 言語ファイルのキー候補を作成
            // 優先度1: block.namespace.id (例: block.minecraft.stone)
            // 優先度2: item.namespace.id (例: item.minecraft.diamond_sword)
            // 優先度3: entity.namespace.id (スポーンエッグなど)
            $candidates = [
                "block.{$namespace}.{$id}",
                "item.{$namespace}.{$id}",
                "entity.{$namespace}.{$id}",
            ];

            $foundName = null;

            foreach ($candidates as $candidate) {
                if (isset($jaJpJson[$candidate])) {
                    $foundName = $jaJpJson[$candidate];
                    break;
                }
            }

            if ($foundName) {
                $item->name = $foundName;
            } else {
                // 見つからない場合
                // すでに名前が入っていれば維持、nullならIDを加工して入れておく（ユーザーが見て何かわかるように）
                if (empty($item->name)) {
                    $item->name = Str::studly(str_replace('_', ' ', $id)); // diamond_sword -> Diamond Sword
                }
                // ログに残すなどは好みで
                // Log::warning("Translation not found for key: {$key}");
            }
            
            $item->save();
        }
    }
}
