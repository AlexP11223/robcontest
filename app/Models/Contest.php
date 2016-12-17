<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contest
 *
 * @property integer $id
 * @property string $name
 * @property boolean $registration_finished
 * @property string $urlSlug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ObstaclesGame[] $obstaclesGames
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SumoGame[] $sumoGames
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contest whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contest whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contest whereIsRegistrationFinished($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contest whereUrlSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contest whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'registration_finished'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($contest) {
            $contest->urlSlug = str_slug($contest->name);
        });
    }

    public function getRouteKeyName()
    {
        return 'urlSlug';
    }

    /**
     * Returns teams
     * @return mixed
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function obstaclesGames()
    {
        return $this
            ->hasManyThrough(ObstaclesGame::class, Team::class)
            ->orderBy('game_index', 'asc')
            ->with('team');
    }

    public function sumoGames()
    {
        return $this
            ->hasManyThrough(SumoGame::class, Team::class, 'contest_id', 'team1_id')
            ->orderBy('round_index', 'asc')
            ->orderBy('game_index', 'asc')
            ->with('team1', 'team2', 'winner');
    }

    /**
     * @return int[]
     */
    public function sumoRoundIndices() {
        return $this->hasManyThrough(SumoGame::class, Team::class, 'contest_id', 'team1_id')
            ->select(['round_index'])
            ->distinct()
            ->orderBy('round_index', 'asc')
            ->get()
            ->map(function($g) {
                return $g->round_index;
            });
    }

    /**
     * Returns the latest contest
     * @return Contest
     */
    public static function current()
    {
        return Contest
            ::orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Returns a collection of old contests (before current)
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function archived()
    {
        $contests = Contest
            ::orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
        $contests->shift();
        return $contests;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function approvedTeams()
    {
        return $this->teams()
            ->whereApproved(true)
            ->get();
    }
}
