<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Notification;

use DB;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleCommentController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'index',
            ]
        ]);
        // 设置 jwt.try_get_user 中间件，用于尝试通过 Token 获取当前登录用户
        $this->middleware('jwt.try_get_user', ['only' => ['index']]);
    }

    public function index(Request $request, $id)
    {
        if (!intval($id)) {
            $article = Article::where('guid', $id)->first();
            $id = $article ? $article->id : 0;
        }

        $query = ArticleComment::with('user')->where('article_id', $id);

        $results = $query->paginate();
        return $this->pagination($results);
    }

    public function store(Request $request, $id)
    {
        $request->merge([
            'user_id' => Auth::id(),
            'article_id' => $id
        ]);
        $rules = [
            'article_id' => 'exists:articles,id,deleted_at,NULL',
            'content' => 'required',
        ];
        $this->validate($request, $rules);

        $params = $request->all();
        $data = ArticleComment::create($params);

        if ($data) {
            // 更新文章评论数
            $comment_count = ArticleComment::where('article_id', $id)->count();
            DB::table('articles')->where('id', $id)->update([
                'comment_count' => $comment_count
            ]);
            // 创建一条消息通知
            $article = Article::find($id);
            if (Auth::id() !== $article->user_id) {
                Notification::create([
                    'user_id'      => $article->user_id,
                    'reason'       => 'comment',
                    'from_user_id' => Auth::id(),
                    'topic_id'     => $article->topic_id,
                    'article_id'   => $id,
                    'article_comment_id' => $data->id,
                ]);
            }
            return $this->success($data);
        }

        return $this->failure();
    }

    public function destroy(Request $request, $id, $comment_id)
    {
        $request->merge([
            'article_id'         => $id,
            'article_comment_id' => $comment_id,
        ]);
        $rules = [
            'article_id'         => 'exists:articles,id,deleted_at,NULL',
            'article_comment_id' => 'exists:article_comments,id,deleted_at,NULL',
        ];
        $this->validate($request, $rules);

        $result = ArticleComment::where('user_id', Auth::id())
            ->where('article_id', $id)
            ->where('id', $comment_id)
            ->delete();
        if ($result) {
            return $this->success();
        }
        return $this->failure();
    }

}
