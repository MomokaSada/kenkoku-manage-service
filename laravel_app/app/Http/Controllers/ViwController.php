<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViwController extends Controller
{
    public function serverInfo()
    {
        return view('serverInfo');
    }
}
