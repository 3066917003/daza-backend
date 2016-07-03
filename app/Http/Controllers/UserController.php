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
        // 执行 auth 认证
        $this->middleware('auth', [
            'except' => [
                'show'
            ]
        ]);
    }

    public function show(Request $request, $user_id)
    {
        $request->merge(['user' => $user_id]);
        $this->validate($request, ['user' => 'exists:users,id']);

        $data = User::find($user_id);
        return $this->success($data);
    }

}
