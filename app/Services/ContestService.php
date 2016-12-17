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

        $contest->isRegistrationFinished = true;
        $contest->save();

        $this->createObstaclesGames($obstaclesTeamIds);
        $this->createInitialSumoRounds($sumoTeamIds);
    }
}
