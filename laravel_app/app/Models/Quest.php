<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = [
        'npc_id',
        'content',
        'is_money_required',
        'required_money',
        'is_money_reward',
        'reward_money',
    ];

    public function npc()
    {
        return $this->belongsTo(Npc::class);
    }

    public function requiredItems()
    {
        return $this->belongsToMany(Item::class, 'quest_items')->withPivot('quantity');
    }

    public function rewardItems()
    {
        return $this->belongsToMany(Item::class, 'reward_items')->withPivot('quantity');
    }

}
