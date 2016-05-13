<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
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

    public function index(Request $request, $id)
    {
        $type = $this->getCommentType($request);

        $rules = [
            'type' => 'required|in:' . implode(',', ['tweet', 'post', 'article', 'event']),
            $type => 'exists:' . $type . 's,id'
        ];

        $request->merge([
            $type  => $id,
            'type' => $type,
        ]);

        $this->validate($request, $rules);

        $query = Comment::where('type', $type)
            ->where('target_id', $id);
        print_r($id);
        print_r($request->all());
        return $this->failure();
    }

    public function store(Request $request, $id)
    {
        return $this->failure();
    }

    public function show(Request $request, $id, $comment_id)
    {
        $type = $this->getCommentType($request);
        // print_r($type);
        // exit;
        $rules = [
            'type' => 'required|in:' . implode(',', ['tweet', 'post', 'article', 'event']),
            $type => 'exists:' . $type . 's,id'
        ];

        $request->merge([
            $type     => $id,
            'comment' => $comment_id,
            'type'    => $type,
        ]);

        // $request->merge([$type => $id]);
        // $rules[$type] = 'exists:' . $type . 's,id';

        $this->validate($request, $rules);

        // if ($request->route()->is('/posts/*')) {
        //     echo 'is_posts';
        // }
        print_r($request->route()->getName());
        print_r($id);
        print_r($comment_id);
        print_r($request->all());
        return $this->failure();
    }

    public function update(Request $request)
    {
        return $this->failure();
    }

    public function destroy(Request $request)
    {
        return $this->failure();
    }

    private function getCommentType(Request $request) {
        $route_name = $request->route()->getName();
        if (strpos($route_name, '.posts')) {
            return 'post1';
        } elseif (strpos($route_name, '.tweets')) {
            return 'tweet';
        }
        return '';
    }

}
