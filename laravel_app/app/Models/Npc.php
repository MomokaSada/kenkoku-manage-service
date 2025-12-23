<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Npc extends Model
{
    protected $fillable = [
        'biome_id',
        'profession_id',
        'npc_type_id',
        'name',
        'level',
    ];

    public function npcType(): BelongsTo
    {
        return $this->belongsTo(NpcType::class);
    }

    public function biome(): BelongsTo
    {
        return $this->belongsTo(Biome::class);
    }

    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
}
