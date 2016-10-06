<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;

class TagController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'index',
                'show',
                'articles',
            ]
        ]);
        // 设置 jwt.try_get_user 中间件，用于尝试通过 Token 获取当前登录用户
        $this->middleware('jwt.try_get_user', ['only' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $query = Tag::orderBy('created_at', 'asc');
        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $tag_name)
    {
        $request->merge(['tag' => $tag_name]);
        $this->validate($request, ['tag' => 'exists:tags,name']);

        $data = Tag::where('name', $tag_name)->first();
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

    public function articles(Request $request, $name)
    {
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

        $article_ids = ArticleTag::where('name', $name)->pluck('article_id');

        $query = Article::select($columns)
            ->with(['user', 'topic'])
            ->whereIn('id', $article_ids)
            ->orderBy('published_at', 'desc');

        return $this->pagination($query->paginate());
    }

}
