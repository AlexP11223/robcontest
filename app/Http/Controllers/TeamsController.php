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

        if ($contest->isRegistrationFinished) {
            abort(404);
        }

        return view('contests.apply');
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

        if ($contest->isRegistrationFinished) {
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
