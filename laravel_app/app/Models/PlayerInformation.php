<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerInformation extends Model
{
    protected $fillable = [
        'player_uuid',
        'player_name',
        'money',
    ];

}
