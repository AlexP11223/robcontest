<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\DynamicHiddenVisible;

/**
 * Represents one obstacles course game, that is time to reach finish of one team
 *
 * @property integer $id
 * @property integer $game_index
 * @property float $time
 * @property integer $team_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Team $team
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ObstaclesGame whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ObstaclesGame whereGameIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ObstaclesGame whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ObstaclesGame whereTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ObstaclesGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ObstaclesGame whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ObstaclesGame extends Model
{
    use DynamicHiddenVisible;

    protected $fillable = [
        'game_index', 'time', 'team_id'
    ];


    /**
     * Returns team of this contest game (each team belongs only to one contest, because teams for all contests are created separately)
     * @return mixed
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
