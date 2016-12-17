<?php

use App\Models\Contest;
use App\Models\ObstaclesGame;
use App\Models\Team;

class SubmitContestResultsTest extends TestCase
{
    private $contest;

    protected function setUp()
    {
        parent::setUp();

        $this->contest = factory(Contest::class)->create([
            'registration_finished' => true
        ]);
        $ind = 0;
        factory(Team::class, 2)->create([
            'contest_id' => $this->contest->id
        ])->each(function(Team $t) use(&$ind) {
            factory(ObstaclesGame::class)->create([
                'team_id' => $t->id,
                'game_index' => $ind++,
            ]);
        });
    }

    /** @test */
    public function can_see_submit_forms()
    {
        $this
            ->actingAs(self::admin())
            ->visit("contests/" . $this->contest->urlSlug);

        $this->seeElement('form.obstacles-form');
    }

    /** @test */
    public function  users_cannot_see_submit_forms()
    {
        $this->visit("contests/" . $this->contest->urlSlug);

        $this->dontSeeElement('form.obstacles-form');
    }

    /** @test */
    public function can_submit_obstacles_result()
    {
        $id = $this->contest->obstaclesGames[0]->id;

        $this
            ->actingAs(self::admin())
            ->put("obstacles/$id/time", ['time' => 42.5 ]);

        $this
            ->assertResponseNot500()
            ->assertResponseOk();

        $this->seeInDatabase('obstacles_games', [
            'id' => $id,
            'time' => 42.5
        ]);
    }

    /** @test */
    public function users_cannot_submit_obstacles_result()
    {
        $id = $this->contest->obstaclesGames[0]->id;

        $this->put("obstacles/$id/time", ['time' => 42.5 ]);

        $this->assertResponseStatus(403);

        $this->dontSeeInDatabase('obstacles_games', [
            'id' => $id,
            'time' => 42.5
        ]);
    }
}
