<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRelationship;

use DB;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserRelationshipController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'followers',
                'following',
            ]
        ]);
        // 设置 jwt.try_get_user 中间件，用于尝试通过 Token 获取当前登录用户
        $this->middleware('jwt.try_get_user', ['only' => ['followers', 'following']]);
    }

    public function store(Request $request, $id)
    {
        $action = $request->input('action');

        $request->merge(['user' => $id]);

        $rules = [
            'user'   => 'exists:users,id',
            'action' =>'required|in:follow,unfollow'
        ];
        $this->validate($request, $rules);

        $user_relationship = UserRelationship::withTrashed()->firstOrCreate([
            'user_id'        => Auth::id(),
            'target_user_id' => $id,
        ]);

        switch ($action) {
            case 'follow':
                $user_relationship->restore();
                break;
            case 'unfollow':
                $user_relationship->delete();
                break;
            default:
                return $this->failure();
        }
        // 更新粉丝数及关注数
        $followers_count = UserRelationship::where('target_user_id', $id)->count();
        $following_count = UserRelationship::where('user_id', $id)->count();
        DB::table('users')->where('id', $id)->update([
            'followers_count'   => $followers_count,
            'following_count' => $following_count
        ]);
        return $this->success();
    }

    public function followers(Request $request, $id)
    {
        $query = UserRelationship::with('user')
            ->where('target_user_id', $id)
            ->orderBy('updated_at', 'desc');

        $results = $query->paginate();
        return $this->pagination($results);
    }

    public function following(Request $request, $id)
    {
        $query = UserRelationship::with('target_user')
            ->where('user_id', $id)
            ->orderBy('updated_at', 'desc');

        $results = $query->paginate();
        return $this->pagination($results);
    }

}
