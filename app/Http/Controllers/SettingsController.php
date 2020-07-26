<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class SettingsController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('settings', [ 'teams' => $teams ]);
    }
}
