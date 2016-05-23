<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\PostVote;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class PostVoteController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth', [
            'except' => [
                'index',
            ]
        ]);
    }

    public function index(Request $request, $post_id)
    {
        $type = $request->query('type');
        $rules = [
            'post_id' => 'exists:posts,id',
            'type'    => 'in:up,down',
        ];
        $this->validate($request, $rules);

        $user_ids = PostVote::where('post_id', $post_id)
            ->where('type', $type)
            ->lists('user_id');

        $query = User::whereIn('id', $user_ids);

        $results = $query->paginate();
        return $this->pagination($results);
    }

    public function store(Request $request, $post_id)
    {
        $type = $request->input('type');
        $rules = [
            'post_id' => 'exists:posts,id',
            'type'  => 'in:up,down',
        ];
        $this->validate($request, $rules);

        $data = PostVote::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post_id,
            'type' => $type,
        ]);
        return $this->success();
    }

}
