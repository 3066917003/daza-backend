<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\ArticleViewer;
use App\Models\Tag;

use DB;
use Auth;
use Carbon\Carbon;
use Crisu83\ShortId\ShortId;

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
        $params = $request->except(['tags']);

        $this->validate($request, [
            'topic_id'    => 'required|exists:topics,id',
            'title'       => 'required|min:2|max:255',
            'content'     => 'min:2',
            'author'      => 'min:2',
            'author_link' => 'url',
            'source'      => 'min:2',
            'source_link' => 'url',
        ]);

        $params = array_merge($params, ['user_id' => Auth::id()]);
        $params['published_at'] = Carbon::now();

        $data = Article::create($params);
        if ($data) {
            // 如果存在 tags 参数，则保存相关的数据
            if ($request->exists('tags')) {
                $tags = $request->input('tags');
                if (!is_array($tags)) {
                    $tags = explode(",", $request->input('tags'));
                }

                $article_tags = [];
                foreach ($tags as $key => $value) {
                    if (strlen($value) == 0) {
                        continue;
                    }
                    array_push($article_tags, new ArticleTag(['name' => ((string) $value)]));
                    // 创建标签，如果存在则会被忽略掉
                    Tag::firstOrCreate(['name' => ((string) $value)]);
                }
                $data->tags()->saveMany($article_tags);
            }
            return $this->success($data);
        }
        return $this->failure();
    }

    public function show(Request $request, $id)
    {
        $request->merge(['article' => $id]);
        $rules = [];

        $query = Article::with(['topic', 'topic.user', 'tags']);

        if (intval($id)) {
            $rules['article'] = 'exists:articles,id';
            $query->where('id', $id);
        } else {
            $rules['article'] = 'exists:articles,guid';
            $query->where('guid', $id);
        }
        $this->validate($request, $rules);

        $data = $query->first();
        // 如果ShortId为空则创建一个
        if (!$data->short_id) {
            $shortid = ShortId::create();
            $data->update(['short_id' => $shortid->generate()]);
        }

        $user_id = Auth::check() ? Auth::id() : 0;

        // 记录文章阅读者记录
        $params = [
            'user_id'    => $user_id,
            'article_id' => $data->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ];
        // 5分钟内同一个阅读者只记数一次
        $dt = Carbon::now();
        $dt->subMinutes(5);
        if (!ArticleViewer::where($params)->where('created_at', '>=', $dt)->exists()) {
            $viewer = ArticleViewer::create($params);
            if ($viewer) {
                $view_count = ArticleViewer::where('article_id', $id)->count();
                DB::table('articles')->where('id', $id)->update(['view_count' => $view_count]);
            }
        }
        return $this->success($data);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['article' => $id]);
        $rules = [
            'article' => 'exists:articles,id,user_id,' . Auth::id(),
        ];
        $this->validate($request, $rules);

        $params = $request->only([
            'topic_id',
            'type',
            'title',
            'summary',
            'content_format',
            'content',
            'image_url',
            'location',
            'longitude',
            'latitude',
        ]);

        $data = Article::find($id);
        if ($data) {
            $data->update($params);
            // 如果存在 tags 参数，则保存相关的数据
            if ($request->exists('tags')) {
                $tags = $request->input('tags');
                if (!is_array($tags)) {
                    $tags = explode(",", $request->input('tags'));
                }

                // 先将不存在的标签删除
                ArticleTag::where('article_id', $id)->whereNotIn('name', $tags)->delete();

                foreach ($tags as $key => $value) {
                    if (strlen($value) == 0) {
                        continue;
                    }
                    ArticleTag::firstOrCreate([
                        'article_id' => $id,
                        'name' => ((string) $value)
                    ]);
                    // 创建标签，如果存在则会被忽略掉
                    Tag::firstOrCreate(['name' => ((string) $value)]);
                }
            }
            return $this->success($data);
        }
        return $this->failure();
    }

    public function destroy(Request $request)
    {
        return $this->failure();
    }

}
