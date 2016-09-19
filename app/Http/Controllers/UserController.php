<?php

namespace App\Http\Controllers;

use App\Models\User;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'show',
                'topics',
            ]
        ]);
        // 设置 jwt.try_get_user 中间件，用于尝试通过 Token 获取当前登录用户
        $this->middleware('jwt.try_get_user', ['only' => ['show', 'topics']]);
    }

    public function show(Request $request, $id)
    {
        $request->merge(['user' => $id]);
        $this->validate($request, ['user' => 'exists:users,id']);

        $data = User::find($id);
        return $this->success($data);
    }

    public function topics(Request $request, $id)
    {
        $data = User::find($id);
        return $this->success($data->topics);
    }

}
