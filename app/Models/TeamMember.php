<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TeamMember
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property \Carbon\Carbon $dob
 * @property \Carbon\Carbon $created_at
 * @property string $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeamMember whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeamMember whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeamMember whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeamMember whereDob($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeamMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeamMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeamMember extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'dob',
    ];

    // columns casted to Carbon datetime type
    public function getDates()
    {
        return ['created_at', 'upated_at', 'dob'];
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'teams_team_members');
    }

    /**
     * @return int
     */
    public function age()
    {
        return $this->dob->age;
    }
}
