<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tweet;
use App\Models\TweetLike;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class TweetLikeController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth:api', [
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
        $action = $request->input('action');
        if (!$action) {
            $action = 'like';
        }

        $rules = [
            'tweet_id' => 'exists:tweets,id',
            'action'   => 'in:like,unlike',
        ];
        $this->validate($request, $rules);

        $data = TweetLike::firstOrCreate([
            'user_id' => Auth::id(),
            'tweet_id' => $tweet_id
        ]);

        switch ($action) {
            case 'like':
                $data->restore();
                break;
            case 'unlike':
                $data->delete();
                break;
            default:
                return $this->failure();
        }

        return $this->success();
    }

}
