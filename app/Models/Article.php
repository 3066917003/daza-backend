<?php

namespace App\Models;

use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'upvoted',
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

    public function getUpvotedAttribute()
    {
        if (Auth::check()) {
            return ArticleVote::where([
                'user_id'    => Auth::id(),
                'article_id' => $this->id,
                'type'       => 'up',
            ])->exists();
        }
        return false;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\ArticleTag');
    }

    public function assets()
    {
        return $this->hasMany('App\Models\Asset', 'target_id')->where('target_type', 'article');
    }

}
