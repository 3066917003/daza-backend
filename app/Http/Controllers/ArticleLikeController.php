<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleLike;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleLikeController extends Controller
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
        $rules = [
            'article' => 'exists:articles,id',
        ];
        $this->validate($request, $rules);

        $query = ArticleLike::with('user')->where('article_id', $id);

        $results = $query->paginate();
        return $this->pagination($results);
    }

    public function store(Request $request, $tweet_id)
    {
        $action = $request->input('action');
        if (!$action) {
            $action = 'like';
        }

        $rules = [
            'article' => 'exists:articles,id',
            'action'  => 'in:like,unlike',
        ];
        $this->validate($request, $rules);

        $data = ArticleLike::firstOrCreate([
            'user_id'    => Auth::id(),
            'article_id' => $tweet_id
        ]);

        switch ($action) {
            case 'like':
                $data->restore();
                break;
            case 'unlike':
                $data->delete();
                break;
            default:
                return $this->failure();
        }

        return $this->success();
    }

}
