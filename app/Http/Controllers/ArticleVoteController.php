<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleVote;
use App\Models\Notification;

use DB;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleVoteController extends Controller
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
        $type = $request->query('type');
        $rules = [
            'article_id' => 'exists:articles,id',
            'type'       => 'in:up,down',
        ];
        $this->validate($request, $rules);

        $query = ArticleVote::where('article_id', $id)
            ->where('type', $type);

        $results = $query->paginate();
        return $this->pagination($results);
    }

    public function store(Request $request, $id)
    {
        $type = $request->input('type');
        $rules = [
            'article_id' => 'exists:articles,id',
            'type'       => 'in:up,down',
        ];
        $this->validate($request, $rules);

        // 每篇文章只能投票一次（顶、踩共一次）
        $data = ArticleVote::firstOrCreate([
            'user_id' => Auth::id(),
            'article_id' => $id,
            'type' => $type,
        ]);
        if ($data) {
            // 更新文章投票数
            $upvote_count   = ArticleVote::where(['article_id' => $id, 'type' => 'up'])->count();
            $downvote_count = ArticleVote::where(['article_id' => $id, 'type' => 'down'])->count();
            DB::table('articles')->where('id', $id)->update([
                'upvote_count'   => $upvote_count,
                'downvote_count' => $downvote_count
            ]);
        }
        // 创建一条消息通知
        $article = Article::find($id);
        if (Auth::id() !== $article->user_id) {
            Notification::create([
                'user_id'      => $article->user_id,
                'reason'       => 'upvoted',
                'from_user_id' => Auth::id(),
                'topic_id'     => $article->topic_id,
                'article_id'   => $id,
            ]);
        }
        return $this->success();
    }

}
