<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends Controller
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

    public function index(Request $request)
    {
        $params = $request->all();

        $query = Article::orderBy('created_at', 'asc');

        if (array_key_exists('category_id', $params)) {
            $query->where('category_id', $params['category_id']);
        }

        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        $params = $request->all();

        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|min:6|max:255',
            'content'     => 'required',
        ]);

        $params = array_merge($params, ['user_id' => Auth::id()]);

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

        $data = Article::find($article_id);
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
