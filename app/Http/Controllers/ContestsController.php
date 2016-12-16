<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContest;
use App\Models\Contest;
use App\Services\ContestService;
use Illuminate\Http\Request;
use Redirect;

class ContestsController extends Controller
{
    protected $contestService;

    public function __construct(ContestService $contestService)
    {
        $this->contestService = $contestService;

        $this->middleware('auth')->except(['show']);
        $this->middleware('role:admin')->except(['show']);
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
        return $contest->name;
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

    public function start(Request $request, Contest $contest)
    {
        $orderedTeamIds = $request['teams'];

        $this->contestService->startContest($contest, $orderedTeamIds);

        return Redirect::route('contests.show', [$contest->urlSlug]);
    }
}
