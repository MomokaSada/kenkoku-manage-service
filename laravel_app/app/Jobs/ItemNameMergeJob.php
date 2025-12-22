<?php

namespace App\Jobs;


use App\Services\ItemNameGetService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ItemNameMergeJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(string|array $minecraftVersion)
    {
        $this->minecraftVersion = $minecraftVersion;
    }

    /**
     * Execute the job.
     */
    public function handle(ItemNameGetService $service): void
    {
        // コンストラクタで受け取ったバージョン配列からバージョン文字列を取り出す
        // リクエストが { "minecraft_version": "1.21.11" } の場合を想定
        // もし配列で来ているならインデックスアクセス、文字列ならそのまま使う
        $version = is_array($this->minecraftVersion) ? ($this->minecraftVersion['minecraft_version'] ?? '1.21.11') : $this->minecraftVersion;

        // 文字列としてServiceに渡す
        $service->execute((string)$version);
    }
}
