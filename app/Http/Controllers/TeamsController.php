<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamApply;
use App\Models\Contest;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Redirect;

class TeamsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['reviewTeams', 'setStatus']);
        $this->middleware('role:admin')->only(['reviewTeams', 'setStatus']);

        $this->middleware('trim');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contest = Contest::current();

        if ($contest->registration_finished) {
            abort(404);
        }

        return view('contests.teams.apply');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeamApply|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamApply $request)
    {
        $contest = Contest::current();

        if ($contest->registration_finished) {
            abort(403);
        }

        $team = Team::create([
            'name' => $request['team'],
            'school' => $request['school'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'teacher_first_name' => $request['teacher_first_name'],
            'teacher_last_name' => $request['teacher_last_name'],
            'sumo' => $request->has('sumo'),
            'obstacles' => $request->has('obstacles'),
            'contest_id' => $contest->id,
        ]);

        $team->addMember(TeamMember::create([
            'first_name' => $request['member1_first_name'],
            'last_name' => $request['member1_last_name'],
            'dob' => $request['member1_dob'],
        ]));
        $team->addMember(TeamMember::create([
            'first_name' => $request['member2_first_name'],
            'last_name' => $request['member2_last_name'],
            'dob' => $request['member2_dob'],
        ]));

        return Redirect::back()->with('success', true);
    }

    /**
     *
     * @param Contest $contest
     * @return \Illuminate\Http\Response
     */
    public function reviewTeams(Contest $contest)
    {
        return view('contests.teams.review', ['contest' => $contest]);
    }

    /**
     *
     * @param Team $team
     * @return \Illuminate\Http\Response
     */
    public function setStatus(Team $team, $status)
    {
        $team->approved = $status == 'approve';
        $team->save();

        return $team->statusText();
    }
}
