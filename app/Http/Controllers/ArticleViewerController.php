<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleViewer;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleViewerController extends Controller
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
        $request->merge(['article' => $id]);
        $rules = [
            'article' => 'exists:articles,id',
        ];
        $this->validate($request, $rules);

        $query = ArticleViewer::with('user')->where('article_id', $id);

        $results = $query->paginate();
        return $this->pagination($results);
    }

}
