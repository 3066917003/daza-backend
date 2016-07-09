<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleComment;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleCommentController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth', [
            'except' => [
                'index',
            ]
        ]);
    }

    public function index(Request $request, $id)
    {
        $request->merge(['article' => $id]);
        $rules = [
            'article' => 'exists:articles,id',
        ];
        $this->validate($request, $rules);

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
            'article_id' => 'exists:articles,id',
        ];
        $this->validate($request, $rules);

        $params = $request->all();
        $data = ArticleComment::create($params);

        if ($data) {
            return $this->success($data);
        }

        return $this->failure();
    }

}
