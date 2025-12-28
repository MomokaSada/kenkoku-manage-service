<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $fillable = [
        'name',
    ];
    
    public function lotteryItems()
    {
        return $this->hasMany(LotteryItems::class);
    }

    public function rarities()
    {
        return $this->hasMany(Rarity::class);
    }
}
