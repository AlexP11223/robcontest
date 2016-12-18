<?php


namespace App\Services;


use App\Models\Contest;
use App\Models\ObstaclesGame;
use App\Models\SumoGame;

class ContestService
{

    public function createObstaclesGames($teamIds)
    {
        foreach ($teamIds as $i => $teamId) {
            ObstaclesGame::create([
                'team_id' => $teamId,
                'game_index' => $i
            ]);
        }
    }

    public function createInitialSumoRounds($teamIds)
    {
        for ($i = 0, $gameInd = 0; $i < count($teamIds); $i += 2, $gameInd++) {
            SumoGame::create([
                'team1_id' => $teamIds[$i],
                'team2_id' => ($i + 1) === count($teamIds) ? null : $teamIds[$i + 1],
                'game_index' => $gameInd,
                'round_index' => 0,
            ]);
        }
    }

    public function startContest(Contest $contest, $orderedTeamIds)
    {
        $teams = $contest->approvedTeams();

        $orderedTeamIds = collect($orderedTeamIds);

        $obstaclesTeamIds = $orderedTeamIds->filter(function($id) use($teams) {
            return $teams->first(function($t) use($id) {
                return $t->id == $id && $t->obstacles;
            }) != null;
        })->values();

        $sumoTeamIds = $orderedTeamIds->filter(function($id) use($teams) {
            return $teams->first(function($t) use($id) {
                return $t->id == $id && $t->sumo;
            }) != null;
        })->values();

        $contest->registration_finished = true;
        $contest->save();

        $this->createObstaclesGames($obstaclesTeamIds);
        $this->createInitialSumoRounds($sumoTeamIds);
    }

    public function setSumoResult(SumoGame $sumoGame, $winnerNumber)
    {
        $contest = $sumoGame->team1->contest;

        $sumoGame->winner_team_id = $winnerNumber == 1 ? $sumoGame->team1_id : $sumoGame->team2_id;
        $sumoGame->save();

        $currentRound = $contest->currentSumoRound();

        if (!$this->alreadyHasFinalSumoRound($contest, $currentRound) && $this->isRoundFinished($currentRound)) {
            $this->createNextSumoRound($currentRound);
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|SumoGame[] $round
     * @return boolean
     */
    public function isRoundFinished($round)
    {
        foreach ($round as $sumoGame) {
            if (!$sumoGame->winner && $sumoGame->team2) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Contest $contest
     * @param \Illuminate\Database\Eloquent\Collection|SumoGame[] $currentRound
     * @return boolean
     */
    public function alreadyHasFinalSumoRound(Contest $contest, $currentRound)
    {
        $indices = $contest->sumoRoundIndices();

        if ($indices->count() > 1) {
            if ($currentRound->count() == 2) {
                $prevRound = $contest->sumoGames()
                    ->whereRoundIndex($indices[$indices->count() - 2])
                    ->get();

                if ($prevRound->count() == 2) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|SumoGame[] $currentRound
     * @return void
     */
    public function createNextSumoRound($currentRound)
    {
        foreach ($currentRound as $sumoGame) {
            if (!$sumoGame->winner && !$sumoGame->team2) {
                $sumoGame->winner_team_id = $sumoGame->team1_id;
            }
        }

        $currentRoundIndex = $currentRound[0]->round_index;

        for ($i = 0, $gameInd = 0; $i < $currentRound->count(); $i += 2, $gameInd++) {
            SumoGame::create([
                'team1_id' => $currentRound[$i]->winner_team_id,
                'team2_id' => ($i + 1) === $currentRound->count() ? null : $currentRound[$i + 1]->winner_team_id,
                'game_index' => $gameInd,
                'round_index' => $currentRoundIndex + 1,
            ]);
        }

        if ($currentRound->count() == 2) {
            SumoGame::create([
                'team1_id' => $currentRound[0]->loserId(),
                'team2_id' => $currentRound[1]->loserId(),
                'game_index' => 1,
                'round_index' => $currentRoundIndex + 1,
            ]);
        }
    }
}
