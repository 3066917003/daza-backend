<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Article;

use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'users',
                'topics',
                'articles',
            ]
        ]);
        // 设置 jwt.try_get_user 中间件，用于尝试通过 Token 获取当前登录用户
        $this->middleware('jwt.try_get_user', ['only' => ['users', 'topics', 'articles']]);
    }

    public function users(Request $request)
    {
        $this->validate($request, ['keyword'=> 'required']);
        $keyword = $request->query('keyword');

        $query = User::orderBy('created_at', 'desc')
            ->orWhere('name'     , 'like', '%'.$keyword.'%')
            ->orWhere('username' , 'like', '%'.$keyword.'%');
        return $this->pagination($query->paginate());
    }

    public function topics(Request $request)
    {
        $this->validate($request, ['keyword'=> 'required']);
        $keyword = $request->query('keyword');

        $query = Topic::orderBy('created_at', 'desc')
            ->with(['user'])
            ->where('name', 'like', '%' . $keyword . '%');
        return $this->pagination($query->paginate());
    }

    public function articles(Request $request)
    {
        $this->validate($request, ['keyword'=> 'required']);
        $keyword = $request->query('keyword');

        $columns = [
            'articles.id',
            'articles.short_id',
            'articles.user_id',
            'articles.topic_id',
            'articles.type',
            'articles.link',
            'articles.title',
            'articles.summary',
            'articles.image_url',
            'articles.location',
            'articles.longitude',
            'articles.latitude',
            'articles.upvote_count',
            'articles.downvote_count',
            'articles.view_count',
            'articles.comment_count',
            'articles.published_at',
        ];

        $query = Article::orderBy('published_at', 'desc')
            ->select($columns)
            ->with(['user', 'topic'])
            ->has('topic')
            ->where('title', 'like', '%' . $keyword . '%');

        return $this->pagination($query->paginate());
    }

}
