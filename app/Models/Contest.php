<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contest
 *
 * @property integer $id
 * @property string $name
 * @property boolean $isRegistrationFinished
 * @property string $urlSlug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
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
        'name', 'isRegistrationFinished'
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
}
