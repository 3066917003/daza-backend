<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;

use Validator;

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
        $query = Category::get();

    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $category_id)
    {
        $rules = array('category' => 'exists:categories,id');
        $validator = Validator::make(['category' => $category_id], $rules);
        if ($validator->fails()) {
            return $this->failure($validator->errors()->all());
        }
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

}
