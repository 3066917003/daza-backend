<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Article;

use Auth;
use Crisu83\ShortId\ShortId;

use Illuminate\Http\Request;

use App\Http\Requests;

class TopicController extends Controller
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
        $query = Topic::orderBy('created_at', 'desc');

        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        $params = $request->all();

        $this->validate($request, [
            'type'           => 'required',
            'name'           => 'required|unique:topics',
            'website'        => 'url',
            // 'image_url'      => 'url',
            // 'description'    => 'required',
            // 'source_format'  => '',
            // 'source_link'    => 'url',
        ]);

        $data = Topic::create($params);
        if ($data) {
            return $this->success($data);
        }
        return $this->failure();
    }

    public function show(Request $request, $id)
    {
        $query = Topic::with('user');
        if (intval($id)) {
            $query->where('id', $id);
        } else {
            $query->where('slug', $id);
        }
        $data = $query->first();
        if (!$data->short_id) {
            $shortid = ShortId::create();
            $data->update(['short_id' => $shortid->generate()]);
        }
        return $this->success($data);
    }

    public function update(Request $request, $id)
    {
        $params = $request->only([
            'category_id',
            'type',
            'source_format',
            'source_link',
            'name',
            'image_url',
            'description',
        ]);

        $data = Topic::find($id);
        if ($data) {
            $data->update($params);
            return $this->success($data);
        }
        return $this->failure();
    }

    public function destroy(Request $request)
    {
        return $this->failure();
    }

    public function articles(Request $request, $id)
    {
        $params = $request->all();

        $columns = [
            'articles.id',
            'articles.short_id',
            'articles.user_id',
            'articles.topic_id',
            'articles.type',
            'articles.title',
            'articles.summary',
            'articles.image_url',
            'articles.upvote_count',
            'articles.downvote_count',
            'articles.view_count',
            'articles.comment_count',
            'articles.published_at',
        ];

        if (!intval($id)) {
            $topic = Topic::where('slug', $id)->first();
            if ($topic) {
                $id = $topic->id;
            }
        }

        $query = Article::select($columns)
            ->with(['user', 'topic'])
            ->where('topic_id', $id)
            ->orderBy('published_at', 'desc');

        return $this->pagination($query->paginate());
    }

}
