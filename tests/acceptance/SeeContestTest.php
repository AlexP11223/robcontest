<?php

use App\Models\Contest;
use App\Models\Team;

class SeeContestTest extends TestCase
{
    /** @test */
    public function can_see_team_list()
    {
        $contest = factory(Contest::class)->create([
            'registration_finished' => true
        ]);
        $teams = factory(Team::class, 3)->create([
            'contest_id' => $contest->id,
            'approved' => true,
        ])
                ->each(function(Team $t) {
                    $t->addMember(factory(\App\Models\TeamMember::class)->create());
                    $t->addMember(factory(\App\Models\TeamMember::class)->create());
                });
        $unapprovedTeams = [
            factory(Team::class)->create([
                'contest_id' => $contest->id,
                'approved' => false,
            ]),
            factory(Team::class)->create([
                'contest_id' => $contest->id,
            ]),
        ];

        $this->visit("contests/$contest->urlSlug");

        $this->see($contest->name);

        foreach ($teams as $team) {
            $this
                ->see($team->name)
                ->see($team->teacher_first_name)
                ->see($team->teacher_last_name)
                ->see($team->members[0]->first_name)
                ->see($team->members[0]->last_name)
                ->see($team->members[1]->first_name)
                ->see($team->members[1]->last_name);

            $this
                ->dontSee($team->email);
        }
        foreach ($unapprovedTeams as $unapprovedTeam) {
            $this->dontSee($unapprovedTeam->name);
        }
    }
}
