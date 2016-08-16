<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPointRecord;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserPointRecordController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'index',
            ]
        ]);
    }

    public function index(Request $request, $tweet_id)
    {
        $rules = [
            'tweet_id' => 'exists:tweets,id',
        ];
        $this->validate($request, $rules);

        $user_ids = TweetLike::where('tweet_id', $tweet_id)->lists('user_id');

        $query = User::whereIn('id', $user_ids);

        $results = $query->paginate();
        return $this->pagination($results);
    }

    public function store(Request $request, $tweet_id)
    {
        return $this->success();
    }

}
