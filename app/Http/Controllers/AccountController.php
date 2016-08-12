<?php

namespace App\Http\Controllers;

use App\Models\User;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class AccountController extends Controller
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
            ]
        ]);
    }

    public function register(Request $request)
    {
        $rules = [
            'username' => 'required|between:4,32|alpha_dash|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|between:6,32',
        ];
        $this->validate($request, $rules);

        $params = $request->only('username', 'email', 'password');
        $params['password'] = bcrypt($params['password']);

        $user = new User($params);
        // 注册时默认使用Gravatar头像
        $user->useGravatar();
        if ($user->save()) {
            return $this->login($request);
        }
        return $this->failure();
    }

    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required|email|exists:users',
            'password' => 'required|between:6,32',
            'username' => 'min:5|max:32|alpha_dash|exists:users',
        ];
        $this->validate($request, $rules);

        $credentials = $request->all();
        $remember = true;

        if (Auth::attempt($credentials, $remember)) {
            return $this->success(Auth::user());
        }

        return $this->failure(trans('auth.failed'), 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return $this->success();
    }

    public function getProfile(Request $request)
    {
        $data = User::find(Auth::id());
        return $this->success($data);
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'name'     => 'min:2|max:32',
            'age'      => 'numeric|between:1,100',
            'gender'   => 'in:' . implode(',', [
                GENDER_UNSPECIFIED,
                GENDER_SECRECY,
                GENDER_MALE,
                GENDER_FEMALE
            ]),
            'birthday' => 'date_format:Y-m-d|before:today'
        ];
        $this->validate($request, $rules);

        $params = $request->except('username', 'email', 'mobile', 'password', 'use_gravatar');
        $use_gravatar = in_array($request->input('use_gravatar'), ['true', 'on', '1']);

        $user = User::find(Auth::id());
        if ($use_gravatar) {
            unset($params['avatar_url']);
            $user->useGravatar();
        }
        if ($user->update($params)) {
            return $this->success($user);
        }
        return $this->failure();
    }

    public function passwordReset(Request $request)
    {
        $email        = $request->input('email');
        $verify_code  = $request->input('verify_code');
        $new_password = $request->input('new_password');

        $rules = [
            'email' => 'required|email|exists:users',
            'verify_code' => 'required|between:4,6',
            'new_password' => 'required|between:6,32',
        ];
        $this->validate($request, $rules);

        $user->where('email', $email)->first();

        $new_password = bcrypt($new_password);
        if ($user->update(['password' => $new_password])) {
            return $this->success($user);
        }

        return $this->failure();
    }

    public function passwordModify(Request $request)
    {
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');

        $rules = [
            'old_password' => 'required|between:6,32',
            'new_password' => 'required|between:6,32',
        ];
        $this->validate($request, $rules);

        $credentials = array(
            'id'       => Auth::id(),
            'password' => $old_password,
        );
        if (!Auth::attempt($credentials, true)) {
            return $this->failure('原密码错误。');
        }

        $new_password = bcrypt($new_password);

        $user = User::find(Auth::id());
        if ($user->update(['password' => $new_password])) {
            return $this->success($user);
        }
        return $this->failure();
    }

}
