<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContest;
use App\Models\Contest;
use App\Models\ObstaclesGame;
use App\Models\Team;
use App\Services\ContestService;
use Illuminate\Http\Request;
use Redirect;

class ContestsController extends Controller
{
    protected $contestService;

    public function __construct(ContestService $contestService)
    {
        $this->contestService = $contestService;

        $this->middleware('auth')->except(['show', 'indexObstacles']);
        $this->middleware('role:admin')->except(['show', 'indexObstacles']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateContest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateContest $request)
    {
        Contest::create([
            'name' => $request['contestName'],
            'isRegistrationFinished' => false
        ]);

        return Redirect::to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param Contest $contest
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        return view('contests.show', ['contest' => $contest, 'teams' => $contest->approvedTeams()]);
    }

    /**
     *
     * @param Contest $contest
     * @return \Illuminate\Http\Response|string
     */
    public function indexTeams(Contest $contest)
    {
        return $contest->teams;
    }

    /**
     *
     * @param Contest $contest
     * @return \Illuminate\Http\Response|string
     */
    public function indexObstacles(Contest $contest)
    {
        // TODO: refactor this weird shit maybe
        ObstaclesGame::setStaticVisible(['game_index', 'time', 'team' ]);
        Team::setStaticVisible(['name' ]);

        $obstaclesGames = $contest->obstaclesGames;

        return $obstaclesGames;
    }

    public function start(Request $request, Contest $contest)
    {
        $orderedTeamIds = $request['teams'];

        $this->contestService->startContest($contest, $orderedTeamIds);

        return Redirect::route('contests.show', [$contest->urlSlug]);
    }
}
