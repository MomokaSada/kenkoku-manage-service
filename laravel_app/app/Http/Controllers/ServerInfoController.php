<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerInfo;

class ServerInfoController extends Controller
{
    public function index()
    {
        return response()->json(ServerInfo::all());
    }
}
