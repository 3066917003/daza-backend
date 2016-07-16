<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class TopicController extends Controller
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
            'image_url'      => 'required|url',
            'description'    => 'required',
            // 'source_format'  => '',
            // 'source_program' => '',
            'source_link'    => 'url',
        ]);

        $data = Topic::create($params);
        if ($data) {
            return $this->success($data);
        }
        return $this->failure();
    }

    public function show(Request $request, $id)
    {
        $data = Topic::find($id);
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
