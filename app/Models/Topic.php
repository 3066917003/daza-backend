<?php

namespace App\Models;

use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'subscribed',
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
        'deleted_at'
    ];

    public function getSubscribedAttribute()
    {
        if (Auth::check()) {
            return TopicSubscriber::where([
                'user_id'  => Auth::id(),
                'topic_id' => $this->id,
            ])->exists();
        }
        return false;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function assets()
    {
        return $this->hasMany('App\Models\Asset', 'target_id')->where('target_type', 'topic');
    }

}
