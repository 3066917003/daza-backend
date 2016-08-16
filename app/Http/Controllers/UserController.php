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
                'show'
            ]
        ]);
    }

    public function show(Request $request, $id)
    {
        $request->merge(['user' => $id]);
        $this->validate($request, ['user' => 'exists:users,id']);

        $data = User::find($id);
        return $this->success($data);
    }

}
