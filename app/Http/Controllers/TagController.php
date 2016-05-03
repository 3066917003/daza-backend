<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tag;

use Validator;

use Illuminate\Http\Request;

use App\Http\Requests;

class TagController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Tag::orderBy('created_at', 'asc');
        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $tag_name)
    {
        $rules = array('tag' => 'exists:tags,name');
        $validator = Validator::make(['tag' => $tag_name], $rules);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }
        $data = Tag::where('name', $tag_name)->first();
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
