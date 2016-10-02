<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\Article;

use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'index',
                'show',
                'topics',
                'articles',
            ]
        ]);
        // 设置 jwt.try_get_user 中间件，用于尝试通过 Token 获取当前登录用户
        $this->middleware('jwt.try_get_user', ['only' => ['index', 'show']]);
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

    public function show(Request $request, $id)
    {
        $request->merge(['category' => $id]);
        $this->validate($request, ['category' => 'exists:categories,id']);

        $data = Category::find($id);
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

    public function topics(Request $request, $id)
    {
        $query = Topic::where('category_id', $id);

        return $this->pagination($query->paginate());
    }

}
