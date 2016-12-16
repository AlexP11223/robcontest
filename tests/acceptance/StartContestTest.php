<?php

use App\Models\Contest;
use App\Models\Team;

class StartContestTest extends TestCase
{
    /** @test */
    public function can_start_contest()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);
        $approvedTeams = factory(Team::class, 4)->create([
            'contest_id' => $contest->id,
            'approved' => true,
        ]);
        $unapprovedTeams = [
            factory(Team::class)->create([
                'contest_id' => $contest->id,
                'approved' => false,
            ]),
            factory(Team::class)->create([
                'contest_id' => $contest->id,
            ]),
        ];

        $teamOrder = [ $approvedTeams[0]->id, $approvedTeams[2]->id, $approvedTeams[3]->id, $approvedTeams[1]->id  ];

        $this
            ->actingAs(self::admin())
            ->patch("contests/$contest->urlSlug/start", ['teams' => $teamOrder ]);

        $this
            ->assertResponseNot500()
            ->assertRedirectedTo("contests/$contest->urlSlug");

        $this->seeInDatabase('contests', [
            'id' => $contest->id,
            'isRegistrationFinished' => true
        ]);

        self::assertCount($approvedTeams->count(), $contest->obstaclesGames);

        foreach ($teamOrder as $i => $approvedTeamId) {
            $this->seeInDatabase('obstacles_games', [
                'team_id' => $approvedTeamId,
                'game_index' => $i
            ]);
        }

        self::assertCount(2, $contest->sumoGames);

        $this->seeInDatabase('sumo_games', [
            'team1_id' => $teamOrder[0],
            'team2_id' => $teamOrder[1],
            'game_index' => 0,
            'round_index' => 0,
        ]);
        $this->seeInDatabase('sumo_games', [
            'team1_id' => $teamOrder[2],
            'team2_id' => $teamOrder[3],
            'game_index' => 1,
            'round_index' => 0,
        ]);
    }

    /** @test */
    public function users_cannot_start_contest()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);
        $approvedTeams = factory(Team::class, 4)->create([
            'contest_id' => $contest->id
        ]);

        $this
            ->patch("contests/$contest->urlSlug/start", ['teams' => [ $approvedTeams[0]->id, $approvedTeams[2]->id, $approvedTeams[3]->id, $approvedTeams[1]->id] ]);

        $this->assertResponseStatus(403);

        $this->seeInDatabase('contests', [
            'id' => $contest->id,
            'isRegistrationFinished' => false
        ]);
    }

    /** @test */
    public function can_see_start_contest_form()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => false
        ]);
        $teams = factory(Team::class, 3)->create([ 'contest_id' => $contest->id ])
            ->each(function(Team $t) {
                $t->addMember(factory(\App\Models\TeamMember::class)->create());
                $t->addMember(factory(\App\Models\TeamMember::class)->create());
            });

        $this
            ->actingAs(self::admin())
            ->visit("contests/$contest->urlSlug/review-teams");

        $this
            ->seeElement('#startContestForm');
    }

    /** @test */
    public function can_see_start_contest_form_only_during_registration_period()
    {
        $contest = factory(Contest::class)->create([
            'isRegistrationFinished' => true
        ]);
        $teams = factory(Team::class, 3)->create([ 'contest_id' => $contest->id ])
            ->each(function(Team $t) {
                $t->addMember(factory(\App\Models\TeamMember::class)->create());
                $t->addMember(factory(\App\Models\TeamMember::class)->create());
            });

        $this
            ->actingAs(self::admin())
            ->visit("contests/$contest->urlSlug/review-teams");

        $this
            ->dontSeeElement('#startContestForm');
    }
}
