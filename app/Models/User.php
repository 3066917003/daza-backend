<?php

namespace App\Models;

use Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

    const GENDER_UNSPECIFIED = 'unspecified';
    const GENDER_SECRECY     = 'secrecy';
    const GENDER_MALE        = 'male';
    const GENDER_FEMALE      = 'female';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'followed',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

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
        'password',
        'remember_token',
        'deleted_at'
    ];

    public function getNameAttribute()
    {
        if (!$this->attributes['name']) {
            return $this->attributes['username'];
        }
        return $this->attributes['name'];
    }

    public function getFollowedAttribute()
    {
        if (Auth::check()) {
            return UserRelationship::where([
                'user_id'        => Auth::id(),
                'target_user_id' => $this->id
            ])->exists();
        }
        return false;
    }

    public function tweets() {
        return $this->hasMany('App\Models\Tweet');
    }

    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function articles() {
        return $this->hasMany('App\Models\Article');
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
