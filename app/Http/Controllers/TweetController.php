<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tweet;

use Illuminate\Http\Request;

use App\Http\Requests;

class TweetController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth', [
            'except' => [
                'index',
                'show'
            ]
        ]);
    }

    public function index(Request $request)
    {
        $query = Tweet::orderBy('created_at', 'asc');
        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $tweet_id)
    {
        $request->merge(['tweet' => $tweet_id]);
        $this->validate($request, ['tweet' => 'exists:tweets,id']);

        $data = Tweet::with('user')->find($tweet_id);
        $this->success($data);
    }

    public function update(Request $request)
    {
        return $this->failure();
    }

    public function destroy(Request $request)
    {
        return $this->failure();
    }

}
