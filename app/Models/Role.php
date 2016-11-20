<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereName($value)
 */
class Role extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function users() {
        return $this->belongsToMany(User::class, 'users_roles');
    }
}
