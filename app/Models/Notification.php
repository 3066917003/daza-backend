<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes, Notifiable;

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
    protected $casts = [
        'unread' => 'boolean'
    ];

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

    public function from_user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    public function article_comment()
    {
        return $this->belongsTo('App\Models\ArticleComment');
    }

    public function routeNotificationForWebhook()
    {
        return 'http://rest.yunba.io:8080';
    }

}
