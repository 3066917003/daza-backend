<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\ArticleViewer;

use DB;
use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'index',
                'show',
            ]
        ]);
        // 设置 jwt.try_get_user 中间件，用于尝试通过 Token 获取当前登录用户
        $this->middleware('jwt.try_get_user', ['only' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $columns = [
            'articles.id',
            'articles.user_id',
            'articles.topic_id',
            'articles.title',
            'articles.summary',
            'articles.image_url',
            'articles.upvote_count',
            'articles.downvote_count',
            'articles.view_count',
            'articles.comment_count',
            'articles.published_at',
        ];

        $query = Article::select($columns)->with(['user', 'topic', 'tags']);

        $category_id   = $request->query('category_id');
        $category_slug = $request->query('category_slug');

        if (!$category_id && !$category_slug) {
            $category_slug = 'latest';
        }

        switch ($category_slug) {
            // 最新的文章
            case 'latest':
                break;
            // 最受欢迎的文章（推荐）
            case 'popular':
                $query->orderBy('articles.upvote_count', 'desc');
                break;
            default:
                // 通过 Slug 查询分类Id
                if ($category_slug) {
                    $category = Category::where('slug', $category_slug)->first();
                    if ($category) {
                        $category_id = $category->id;
                    }
                }
                $query->leftJoin('topics', 'articles.topic_id', '=', 'topics.id');
                $query->where('topics.category_id', $category_id);
                break;
        }

        $query->orderBy('articles.published_at', 'desc');

        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        $params = $request->all();

        $this->validate($request, [
            'topic_id'    => 'required|exists:topics,id',
            'title'       => 'required|min:6|max:255',
            'content'     => 'required',
            'author'      => 'min:2',
            'author_link' => 'url',
            'source'      => 'min:2',
            'source_link' => 'url',
        ]);

        $params = array_merge($params, ['user_id' => Auth::id()]);
        $params['published_at'] = Carbon::now();

        $data = Article::create($params);
        if ($data) {
            return $this->success($data);
        }
        return $this->failure();
    }

    public function show(Request $request, $article_id)
    {
        $request->merge(['article' => $article_id]);
        $this->validate($request, ['article' => 'exists:articles,id']);

        $user_id = Auth::check() ? Auth::id() : 0;

        // 记录文章阅读者记录
        $params = [
            'user_id'    => $user_id,
            'article_id' => $article_id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ];
        // 5分钟内同一个阅读者只记数一次
        $dt = Carbon::now();
        $dt->subMinutes(5);
        if (!ArticleViewer::where($params)->where('created_at', '>=', $dt)->exists()) {
            $viewer = ArticleViewer::create($params);
            if ($viewer) {
                $view_count = ArticleViewer::where('article_id', $article_id)->count();
                DB::table('articles')->where('id', $article_id)->update(['view_count' => $view_count]);
            }
        }

        $data = Article::with(['topic', 'topic.user', 'tags'])->find($article_id);
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
