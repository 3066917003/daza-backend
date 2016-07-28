<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;

use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Category::orderBy('created_at', 'asc');
        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $category_id)
    {
        $request->merge(['category' => $category_id]);
        $this->validate($request, ['category' => 'exists:categories,id']);

        $data = Category::find($category_id);
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

    public function articles(Request $request, $id)
    {
        $params = $request->all();

        $columns = [
            'articles.id',
            'articles.user_id',
            'articles.topic_id',
            'articles.title',
            'articles.summary',
            'articles.image_url',
            'articles.view_count',
            'articles.like_count',
            'articles.comment_count',
            'articles.published_at',
        ];

        $query = Article::select($columns)
            ->with(['user', 'topic'])
            ->leftJoin('topics', 'articles.topic_id', '=', 'topics.id')
            ->where('topics.category_id', $id)
            ->orderBy('published_at', 'desc');

        return $this->pagination($query->paginate());
    }

}
