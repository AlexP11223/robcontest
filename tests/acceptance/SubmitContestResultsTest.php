<?php

use App\Models\Contest;
use App\Models\ObstaclesGame;
use App\Models\SumoGame;
use App\Models\Team;

class SubmitContestResultsTest extends TestCase
{
    /**
     * @var Contest
     */
    private $contest;

    protected function setUp()
    {
        parent::setUp();

        $this->contest = factory(Contest::class)->create([
            'registration_finished' => true
        ]);
        $ind = 0;
        $teams = factory(Team::class, 16)->create([
            'contest_id' => $this->contest->id
        ])->each(function(Team $t) use(&$ind) {
            factory(ObstaclesGame::class)->create([
                'team_id' => $t->id,
                'game_index' => $ind++,
            ]);
        });

        $ind = 0;
        $winners = [];
        for ($i = 0; $i < $teams->count(); $i += 2) {
            SumoGame::create([
                'team1_id' => $teams[$i]->id,
                'team2_id' => $teams[$i + 1]->id,
                'winner_team_id' => $teams[$i + 1]->id,
                'round_index' => 0,
                'game_index' => $ind++,
            ]);
            $winners[] = $teams[$i + 1]->id;
        }
        $ind = 0;
        for ($i = 0; $i < count($winners); $i += 2) {
            SumoGame::create([
                'team1_id' => $winners[$i],
                'team2_id' => $winners[$i + 1],
                'round_index' => 1,
                'game_index' => $ind++,
            ]);
        }
    }

    /** @test */
    public function can_see_submit_forms()
    {
        $this
            ->actingAs(self::admin())
            ->visit("contests/" . $this->contest->urlSlug);

        $this
            ->seeElement('form.obstacles-form')
            ->seeElement('#sumoFormPanel');
    }

    /** @test */
    public function  users_cannot_see_submit_forms()
    {
        $this->visit("contests/" . $this->contest->urlSlug);

        $this
            ->dontSeeElement('form.obstacles-form')
            ->dontSeeElement('#sumoFormPanel');
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

    /** @test */
    public function can_get_sumo_forms()
    {
        $this
            ->actingAs(self::admin())
            ->visit("contests/" . $this->contest->urlSlug . "/sumo/edit");

        foreach ($this->contest->currentSumoRound() as $sumoGame) {
            $this->seeElement("form.sumo-form[action*=\"$sumoGame->id\"]");
        }

        $otherRoundGame = $this->contest->sumoGames()->first();
        $this->dontSeeElement("form.sumo-form[action*=\"$otherRoundGame->id\"]");
    }

    /** @test */
    public function does_not_show_sumo_form_for_null_team()
    {
        $nullGame = $this->contest->currentSumoRound()[0];
        $nullGame->team2_id = null;
        $nullGame->save();

        $this
            ->actingAs(self::admin())
            ->visit("contests/" . $this->contest->urlSlug . "/sumo/edit");

        $this->seeElement("form.sumo-form");

        $this->dontSeeElement("form.sumo-form[action*=\"$nullGame->id\"]");
    }

    /** @test */
    public function can_submit_sumo_results()
    {
        $currentRound = $this->contest->currentSumoRound();

        $winners = [ 1, 1, 2, 1 ];
        $firstRoundWinnerIds = [];
        for ($i = 0; $i < $currentRound->count(); $i++) {
            $sumoGame = $currentRound[$i];

            $winnerId = $winners[$i] === 1 ? $sumoGame->team1->id : $sumoGame->team2->id;
            $firstRoundWinnerIds[] = $winnerId;

            $this
                ->actingAs(self::admin())
                ->put("sumo/$sumoGame->id/result", ['winner' => $winners[$i] ]);

            $this
                ->assertResponseNot500()
                ->assertResponseOk();

            $this->seeInDatabase('sumo_games', [
                'id' => $sumoGame->id,
                'winner_team_id' => $winnerId
            ]);
        }

        $currentRound = $this->contest->currentSumoRound();

        self::assertCount(2, $currentRound);

        $winners = [ 1, 1 ];
        $secondRoundWinnerIds = [];
        $secondRoundLoserIds = [];
        for ($i = 0, $j = 0; $i < $currentRound->count(); $i++, $j += 2) {
            $sumoGame = $currentRound[$i];

            self::assertEquals($firstRoundWinnerIds[$j], $sumoGame->team1->id);
            self::assertEquals($firstRoundWinnerIds[$j + 1], $sumoGame->team2->id);

            $winnerId = $winners[$i] === 1 ? $sumoGame->team1->id : $sumoGame->team2->id;
            $loserId = $winners[$i] === 1 ? $sumoGame->team2->id : $sumoGame->team1->id;
            $secondRoundWinnerIds[] = $winnerId;
            $secondRoundLoserIds[] = $loserId;

            $this
                ->actingAs(self::admin())
                ->put("sumo/$sumoGame->id/result", ['winner' => $winners[$i] ]);

            $this
                ->assertResponseNot500()
                ->assertResponseOk();

            $this->seeInDatabase('sumo_games', [
                'id' => $sumoGame->id,
                'winner_team_id' => $winnerId
            ]);
        }

        $currentRound = $this->contest->currentSumoRound();

        self::assertCount(2, $currentRound);

        self::assertEquals($secondRoundWinnerIds[0], $currentRound[0]->team1->id);
        self::assertEquals($secondRoundWinnerIds[1], $currentRound[0]->team2->id);

        self::assertEquals($secondRoundLoserIds[0], $currentRound[1]->team1->id);
        self::assertEquals($secondRoundLoserIds[1], $currentRound[1]->team2->id);

        foreach ($currentRound as $sumoGame) {
            $this
                ->actingAs(self::admin())
                ->put("sumo/$sumoGame->id/result", ['winner' => 1 ]);

            $this
                ->assertResponseNot500()
                ->assertResponseOk();

            $this->seeInDatabase('sumo_games', [
                'id' => $sumoGame->id,
                'winner_team_id' => $sumoGame->team1->id
            ]);
        }

        // no next round

        $currentRound = $this->contest->currentSumoRound();

        self::assertCount(2, $currentRound);

        self::assertEquals($secondRoundWinnerIds[0], $currentRound[0]->team1->id);
        self::assertEquals($secondRoundWinnerIds[1], $currentRound[0]->team2->id);

        self::assertEquals($secondRoundLoserIds[0], $currentRound[1]->team1->id);
        self::assertEquals($secondRoundLoserIds[1], $currentRound[1]->team2->id);
    }

    /** @test */
    public function can_submit_sumo_results_when_not_enough_teams()
    {
        // 6 initial teams
        $this->contest->currentSumoRound()[3]->update(['team2_id' => null]);

        $currentRound = $this->contest->currentSumoRound();

        $winners = [ 1, 1, 2];
        $firstRoundWinnerIds = [];
        for ($i = 0; $i < count($winners); $i++) {
            $sumoGame = $currentRound[$i];

            $winnerId = $winners[$i] === 1 ? $sumoGame->team1->id : $sumoGame->team2->id;
            $firstRoundWinnerIds[] = $winnerId;

            $this
                ->actingAs(self::admin())
                ->put("sumo/$sumoGame->id/result", ['winner' => $winners[$i] ]);

            $this
                ->assertResponseNot500()
                ->assertResponseOk();

            $this->seeInDatabase('sumo_games', [
                'id' => $sumoGame->id,
                'winner_team_id' => $winnerId
            ]);
        }

        $firstRoundWinnerIds[] = $currentRound[3]->team1_id;

        $currentRound = $this->contest->currentSumoRound();

        self::assertCount(2, $currentRound);

        for ($i = 0, $j = 0; $i < $currentRound->count(); $i++, $j += 2) {
            $sumoGame = $currentRound[$i];

            self::assertEquals($firstRoundWinnerIds[$j], $sumoGame->team1->id);
            self::assertEquals($firstRoundWinnerIds[$j + 1], $sumoGame->team2->id);
        }
    }
}
