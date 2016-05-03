<?php

namespace App\Http\Controllers;

use App\Models\User;

use Auth;
use Validator;

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
        $username = $request->input('username');
        $password = $request->input('password');

        $params = array(
            'username' => $username,
            'password' => $password,
        );

        $rules = array(
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6',
        );
        $validator = Validator::make($params, $rules);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }

        $params['password'] = bcrypt($password);

        $user = User::create($params);
        if ($user) {
            return $this->login($request);
        }
        return $this->failure();
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = true;

        $credentials = array(
            'username' => $username,
            'password' => $password
        );

        $rules = array(
            'username' => 'required|max:255',
            'password' => 'required|min:6',
        );

        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }

        if (Auth::attempt($credentials, $remember)) {
            return $this->success(Auth::user());
        }

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
        $rules = array('user' => 'exists:users,id');
        $validator = Validator::make(['user' => $user_id], $rules);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }
        $user = User::find($user_id);
        return $this->success($user);
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
