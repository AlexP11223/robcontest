
<?php

use App\Models\Contest;
use App\Models\ObstaclesGame;
use App\Models\Team;

class GetContestInfoTest extends TestCase
{
    /** @test */
    public function can_get_team_list()
    {
        $contest = factory(Contest::class)->create();
        $teams = factory(Team::class, 2)->create([
            'contest_id' => $contest->id
        ]);

        $this
            ->actingAs(self::admin())
            ->get("contests/$contest->urlSlug/teams");

        $this->assertResponseOk();

        foreach ($teams as $team) {
            $this->seeJson([
                'id' => $team->id,
                'name' => $team->name,
            ]);
        }
    }

    /** @test */
    public function only_admin_can_get_full_team_list()
    {
        $contest = factory(Contest::class)->create();
        $teams = factory(Team::class, 2)->create([
            'contest_id' => $contest->id
        ]);

        $this->get("contests/$contest->urlSlug/teams");

        $this->assertRedirectedToRoute('login');
    }

    /** @test */
    public function can_get_obstacles_info ()
    {
        $contest = factory(Contest::class)->create();
        $ind = 0;
        $teams = factory(Team::class, 2)->create([
            'contest_id' => $contest->id
        ])->each(function(Team $t) use($ind) {
            factory(ObstaclesGame::class)->create([
                'team_id' => $t->id,
                'game_index' => $ind++,
            ]);
        });

        $this->get("contests/$contest->urlSlug/obstacles");

        $this->assertResponseOk();

        foreach ($teams as $team) {
            $this->seeJson([
                'name' => $team->name,
                'time' => $team->obstaclesGames[0]->time,
            ]);
            $this->dontSeeJson([
                'email' => $team->email,
            ]);
        }
    }

}
