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
                'register',
                'login',
                'logout',
                'passwordReset',
                'show'
            ]
        ]);
    }

    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:32',
            'username' => 'min:5|max:32|alpha_dash|unique:users',
        ];
        $this->validate($request, $rules);

        $request->merge(['password' => bcrypt($request->input('password'))]);

        $user = User::create($request->all());
        if ($user) {
            return $this->success($user);
        }
        return $this->failure();
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|max:32',
            'username' => 'min:5|max:32|alpha_dash|unique:users',
        ];
        $this->validate($request, $rules);

        $credentials = $request->all();
        $remember = true;

        if (Auth::attempt($credentials, $remember)) {
            return $this->success(Auth::user());
        }

        return $this->failure(trans('auth.failed'));
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
        $request->merge(['user' => $user_id]);
        $this->validate($request, ['user' => 'exists:users,id']);

        $data = User::find($user_id);
        return $this->success($data);
    }

    public function update(Request $request, $user_id)
    {
        return $this->failure();
    }

    public function destroy(Request $request, $user_id)
    {
        return $this->failure();
    }

}
