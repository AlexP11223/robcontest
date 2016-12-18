<?php

use App\Models\Contest;
use App\Models\SumoGame;
use App\Models\Team;

class ContestTest extends TestCase
{
    /** @test */
    public function current_returns_latest_contest()
    {
        $oldContest = factory(Contest::class)->create([
            'name' => 'RobLeg 2000'
        ]);
        $newContest = factory(Contest::class)->create([
            'name' => 'RobLeg 2001'
        ]);

        $this->assertEquals($newContest->id, Contest::current()->id);
        $this->assertEquals($newContest->name, Contest::current()->name);
    }

    /** @test */
    public function returns_archived_contests()
    {
        $oldContests = factory(Contest::class, 2)->create();
        $newContest = factory(Contest::class)->create();

        $archivedContests = Contest::archived();

        $this->assertCount(Contest::count() - 1, $archivedContests);
        $this->assertFalse($archivedContests->contains($newContest), 'Has current contest');
        foreach ($oldContests as $oldContest) {
            $this->assertTrue($archivedContests->contains($oldContest), 'Does not have old contests');
        }
    }

    /** @test */
    public function has_slug_when_created()
    {
        $contest = Contest::create([
            'name' => 'RobLeg 2001',
            'registration_finished' => false,
        ]);

        $this->assertEquals('robleg-2001', $contest->urlSlug);
    }

    /** @test */
    public function returns_approved_teams()
    {
        $contest = factory(Contest::class)->create([
            'registration_finished' => false
        ]);
        $approvedTeams = factory(Team::class, 2)->create([
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

        $result = $contest->approvedTeams();

        self::assertCount($approvedTeams->count(), $result);

        foreach ($approvedTeams as $approvedTeam) {
            self::assertTrue($result->contains('id', $approvedTeam->id));
        }
    }

    /** @test */
    public function returns_sumo_round_indices()
    {
        $contest = factory(Contest::class)->create([
            'registration_finished' => true
        ]);
        $team = factory(Team::class)->create([
            'contest_id' => $contest->id,
        ]);
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 2; $j++) {
                SumoGame::create([
                    'team1_id' => $team->id,
                    'team2_id' => $team->id,
                    'round_index' => $i,
                    'game_index' => $j,
                ]);
            }
        }

        $indices = $contest->sumoRoundIndices();

        self::assertCount(3, $indices);

        for ($i = 0; $i < 3; $i++) {
            self::assertEquals($i, $indices[$i]);
        }
    }

    /** @test */
    public function returns_current_sumo_round()
    {
        $contest = factory(Contest::class)->create([
            'registration_finished' => true
        ]);
        $team = factory(Team::class)->create([
            'contest_id' => $contest->id,
        ]);
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 2; $j++) {
                SumoGame::create([
                    'team1_id' => $team->id,
                    'team2_id' => $team->id,
                    'round_index' => $i,
                    'game_index' => $j,
                ]);
            }
        }

        $currentRound = $contest->currentSumoRound();

        self::assertCount(2, $currentRound);

        for ($i = 0; $i < 2; $i++) {
            self::assertEquals(2, $currentRound[$i]->round_index);
        }
    }
}
