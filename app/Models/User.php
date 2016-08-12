<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Validator;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

define('GENDER_UNSPECIFIED' , 'unspecified');
define('GENDER_SECRECY'     , 'secrecy');
define('GENDER_MALE'        , 'male');
define('GENDER_FEMALE'      , 'female');

class User extends Authenticatable
{
    use SoftDeletes;

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
        'mobile',
        'password',
        'first_name',
        'last_name',
        'country',
        'address',
        'phone',
        'status',
        'remember_token',
        'deleted_at',
    ];

    public function getNameAttribute()
    {
        if (!$this->attributes['name']) {
            return $this->attributes['username'];
        }
        return $this->attributes['name'];
    }

    public function getAgeAttribute()
    {
        $age = $this->attributes['age'];
        $birthday = $this->attributes['birthday'];

        $rules = ['birthday' => 'required|date_format:Y-m-d|before:today'];

        $validator = Validator::make(['birthday' => $birthday], $rules);

        if (!$validator->fails()) {
            $today = Carbon::today();
            $birthday_dt = Carbon::createFromFormat('Y-m-d', $birthday);
            $age = $today->diffInYears($birthday_dt);
        }
        return $age;
    }

    public function getFollowedAttribute()
    {
        if (Auth::check()) {
            if (Auth::id() == $this->id) {
                return true;
            }
            return UserRelationship::where([
                'user_id'        => Auth::id(),
                'target_user_id' => $this->id
            ])->exists();
        }
        return false;
    }

    // 使用Gravatar
    public function useGravatar()
    {
        $this->avatar_url = "https://cn.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) );
    }

    public function topics()
    {
        return $this->hasMany('App\Models\Topic');
    }

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function tweets()
    {
        return $this->hasMany('App\Models\Tweet');
    }

    public function events()
    {
        // TODO: 关联用户参加的活动
        return $this->hasMany('App\Models\Event');
    }

    public function assets()
    {
        return $this->hasMany('App\Models\Asset', 'target_id')->where('target_type', 'article');
    }

}
