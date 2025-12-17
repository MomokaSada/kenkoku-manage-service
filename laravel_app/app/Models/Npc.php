<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Npc extends Model
{
    protected $fillable = [
        'biome_id',
        'profession_id',
        'name',
        'type',
        'level',
    ];
    public function quests()
    {
        return $this->hasMany(Quest::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
