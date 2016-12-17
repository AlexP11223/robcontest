<?php

namespace App\Http\Controllers;

use App\Models\ObstaclesGame;
use Illuminate\Http\Request;

class ObstaclesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     *
     * @param Request $request
     * @param ObstaclesGame $obstaclesGame
     * @return \Illuminate\Http\Response
     */
    public function setScore(Request $request, ObstaclesGame $obstaclesGame)
    {
        $obstaclesGame->time = (float) $request['time'];

        $obstaclesGame->save();

        return "ok";
    }
}
