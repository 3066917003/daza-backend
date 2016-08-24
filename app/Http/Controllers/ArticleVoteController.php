<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleVote;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleVoteController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth:api', [
            'except' => [
                'index',
            ]
        ]);
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
            Article::find($id)->update([
                'upvote_count'   => $upvote_count,
                'downvote_count' => $downvote_count
            ]);
        }
        return $this->success();
    }

}
