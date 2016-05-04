<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
    ];

    public function tweets() {
        return $this->hasMany('App\Models\Tweet');
    }

    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function groups() {
        // TODO: 关联用户加入的小组
        return $this->hasMany('App\Models\Group');
    }

    public function events() {
        // TODO: 关联用户参加的活动
        return $this->hasMany('App\Models\Event');
    }

}
