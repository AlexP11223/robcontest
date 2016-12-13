<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Team
 *
 * @property integer $id
 * @property string $name
 * @property string $teacher_first_name
 * @property string $teacher_last_name
 * @property string $email
 * @property string $phone
 * @property string $school
 * @property boolean $sumo
 * @property boolean $obstacles
 * @property integer $contest_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TeamMember[] $members
 * @property-read \App\Models\Contest $contest
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereTeacherFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereTeacherLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereSchool($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereSumo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Team whereObstacles($value)
 * @mixin \Eloquent
 */
class Team extends Model
{
    protected $fillable = [
        'name', 'school', 'email', 'phone', 'teacher_first_name', 'teacher_last_name', 'sumo', 'obstacles', 'contest_id'
    ];

    /**
     * Returns team members
     * @return mixed
     */
    public function members()
    {
        return $this->belongsToMany(TeamMember::class, 'teams_team_members')->withTimestamps();
    }

    /**
     * Returns contest of this team (each team has only one contest, teams for all contests are created separately)
     * @return mixed
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Adds a member to the team
     *
     * @param TeamMember $member
     * @return mixed
     */
    public function addMember($member)
    {
        return $this->members()->attach($member);
    }
}
