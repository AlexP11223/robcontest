<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\SumoGame;
use App\Services\ContestService;
use Illuminate\Http\Request;

class SumoController extends Controller
{
    protected $contestService;

    public function __construct(ContestService $contestService)
    {
        $this->contestService = $contestService;

        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contest $contest
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        return view('contests.sumoform', ['contest' => $contest]);
    }

    /**
     *
     * @param Request $request
     * @param SumoGame $sumoGame
     * @return \Illuminate\Http\Response
     */
    public function setResult(Request $request, SumoGame $sumoGame)
    {
        $this->contestService->setSumoResult($sumoGame, (int) $request['winner']);

        return "ok";
    }

}
