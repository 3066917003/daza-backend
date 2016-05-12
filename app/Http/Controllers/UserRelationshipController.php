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
        return $this->failure();
    }

    public function store(Request $request, $user_id)
    {
        $action = $request->input('action');

        $request->merge(['user' => $user_id]);

        $rules = [
            'user' => 'exists:users,id',
            'action' =>'required|in:follow,unfollow'
        ];
        $this->validate($request, $rules);

        $user_relationship = UserRelationship::withTrashed()->firstOrCreate([
            'user_id' => Auth::id(),
            'target_user_id' => $user_id,
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

    public function show(Request $request, $tweet_id)
    {
        return $this->failure();
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
