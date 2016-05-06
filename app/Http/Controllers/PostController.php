<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;

use Validator;

use Illuminate\Http\Request;

use App\Http\Requests;

class PostController extends Controller
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
        $query = Post::orderBy('created_at', 'asc');
        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $post_id)
    {
        $rules = array('post' => 'exists:posts,id');
        $validator = Validator::make(['post' => $post_id], $rules);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }
        $data = Post::find($post_id);
        return $this->success($data);
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
