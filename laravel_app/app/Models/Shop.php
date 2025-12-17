<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'npc_id',
        'content',
    ];

    public function npc()
    {
        return $this->belongsTo(Npc::class);
    }

    public function products()
    {
        return $this->belongsToMany(Item::class, 'product_items')->withPivot('quantity');
    }
}
