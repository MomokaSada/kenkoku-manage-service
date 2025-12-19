<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NpcType extends Model
{
    protected $fillable = [
        'name',
    ];
    public function npcs()
    {
        return $this->hasMany(Npc::class);
    }
}
