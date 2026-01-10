<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViwController; 

Route::get('server-info', [ViwController::class, 'serverInfo'])->name('server-info');
Route::get('npc-system-info', [ViwController::class, 'npcSystemInfo'])->name('npc-system-info');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');


