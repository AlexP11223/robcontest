<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents one game of sumo round, that is which one of two teams won
 *
 * @property integer $id
 * @property integer $game_index
 * @property integer $round_index
 * @property integer $team1_id
 * @property integer $team2_id
 * @property integer $winner_team_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Team $team1
 * @property-read \App\Models\Team $team2
 * @property-read \App\Models\Team $winner
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SumoGame whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SumoGame whereGameIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SumoGame whereRoundIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SumoGame whereTeam1Id($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SumoGame whereTeam2Id($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SumoGame whereWinnerTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SumoGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SumoGame whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SumoGame extends Model
{
    protected $fillable = [
        'game_index', 'round_index', 'team1_id', 'team2_id'
    ];

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    public function winner()
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }
}
