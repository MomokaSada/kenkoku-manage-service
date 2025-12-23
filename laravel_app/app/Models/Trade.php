<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trade extends Model
{
    protected $fillable = [
        'npc_id',
        'content',
    ];

    public function npc(): BelongsTo
    {
        return $this->belongsTo(Npc::class);
    }

    public function rewards(): HasMany
    {
        return $this->hasMany(Reward::class);
    }
    public function costs(): HasMany
    {
        return $this->hasMany(TradeCosts::class);
    }
}
