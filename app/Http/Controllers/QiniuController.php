<?php

namespace App\Http\Controllers;

use Qiniu\Auth as QiniuAuth;

use Illuminate\Http\Request;

use App\Http\Requests;

class QiniuController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        // $this->middleware('jwt.auth');
    }

    public function token(Request $request)
    {
        $qiniu_auth = new QiniuAuth(env('QINIU_ACCESS_KEY', ''), env('QINIU_SECRET_KEY', ''));
        $qiniu_token = $qiniu_auth->uploadToken(env('QINIU_BUCKET_NAME', ''));

        $result = [
            'uptoken' => $qiniu_token,
        ];
        return response($result);
    }

}
