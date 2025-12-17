<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biome extends Model
{
    protected $fillable = [
        'name',
        'key',
    ];

    public function npcs()
    {
        return $this->hasMany(Npc::class);
    }
}
