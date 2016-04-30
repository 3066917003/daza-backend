<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth', ['except' => ['register', 'login', 'passwordReset']]);
    }

    public function register(Request $request)
    {
        return $this->failure();
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $credentials = array(
          'username' => $username,
          'password' => $password
        );

        return $this->failure();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return $this->success();
    }

    public function passwordReset(Request $request)
    {
        return $this->failure();
    }

    public function passwordModify(Request $request)
    {
        return $this->failure();
    }

    public function index(Request $request)
    {
        return $this->failure();
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $user_id)
    {
        $result = User::find($user_id);
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
