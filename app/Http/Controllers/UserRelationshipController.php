<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRelationship;

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
