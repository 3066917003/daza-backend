<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tag;

use Illuminate\Http\Request;

use App\Http\Requests;

class VoteController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth', [
            'except' => [
                'index',
            ]
        ]);
    }

    public function index(Request $request)
    {
        return $this->failure();
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

}
