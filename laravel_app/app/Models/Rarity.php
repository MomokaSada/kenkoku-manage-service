<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    protected $fillable = [
        'name',
        'range',
        'probability',
    ];

    public function lotteryItems()
    {
        return $this->hasMany(LotteryItems::class);
    }
}
