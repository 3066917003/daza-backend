<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;

use Illuminate\Http\Request;

use App\Http\Requests;

class OrderController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Order::orderBy('created_at', 'asc');
        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $order_no)
    {
        $request->merge(['order' => $order_no]);
        $this->validate($request, ['order' => 'exists:orders,order_no']);

        $data = Order::where('user_id', Auth::id())
            ->where('order_no', $order_no)
            ->first();
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
