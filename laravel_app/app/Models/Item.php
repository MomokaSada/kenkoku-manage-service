<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'key',
        'is_original',
        'nbt',
    ];

    public function quests()
    {
        return $this->belongsToMany(Quest::class, 'quest_items')->withPivot('quantity');
    }

    public function rewards()
    {
        return $this->belongsToMany(Quest::class, 'reward_items')->withPivot('quantity');
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'product_items')->withPivot('quantity');
    }
}
