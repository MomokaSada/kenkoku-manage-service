<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryItems extends Model
{
    protected $fillable = [
        'lottery_id',
        'item_id',
        'rarity_id',
        'quantity',
    ];

    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function rarity()
    {
        return $this->belongsTo(Rarity::class);
    }
}
