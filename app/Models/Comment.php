<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    const TYPE_TWEET   = 'tweet';
    const TYPE_POST    = 'post';
    const TYPE_ARTICLE = 'article';
    const TYPE_EVENT   = 'event';

    const TYPES = [TYPE_TWEET, TYPE_POST, TYPE_ARTICLE, TYPE_EVENT];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

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
        'type',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
