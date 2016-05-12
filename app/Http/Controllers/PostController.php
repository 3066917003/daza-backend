<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;

use Auth;

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
        $query = Post::orderBy('created_at', 'asc')
            ->with('user')
            ->with('category');

        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $data = Post::create($request->all());
        if ($data) {
            return $this->success($data);
        }
        return $this->failure();
    }

    public function show(Request $request, $post_id)
    {
        $request->merge(['post' => $post_id]);
        $this->validate($request, ['post' => 'exists:posts,id']);

        $data = Post::with('user')
            ->with('category')
            ->find($post_id);
        return $this->success($data);
    }

    public function update(Request $request)
    {
        return $this->failure();
    }

    public function destroy(Request $request, $post_id)
    {
        $request->merge(['post' => $post_id]);
        $this->validate($request, ['post' => 'exists:posts,id,user_id,' . Auth::id()]);

        $data = Post::where($post_id);
        $data->delete();
        return $this->failure();
    }

}
