<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function groups() {
        return $this->belongsToMany('App\Group', 'groups_roles_users', 'group_id', 'user_id');
            //->withPivot('id_role');
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'groups_roles_users', 'user_id', 'role_id')
            ->withPivot('group_id');
    }

    public function getGroupRole($group_id) {
        return $this->roles()->wherePivot('group_id', $group_id)->get();
    }

}
