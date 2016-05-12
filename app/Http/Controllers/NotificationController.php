<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;

use Illuminate\Http\Request;

use App\Http\Requests;

class NotificationController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $type = $request->query('type');

        $query = Notification::orderBy('created_at', 'asc');

        if ($type) {
            $query->where('type', $type);
        }

        return $this->pagination($query->paginate());
    }

    public function show(Request $request, $notification_id)
    {
        $request->merge(['notification' => $notification_id]);
        $this->validate($request, ['notification' => 'exists:notifications,id']);

        $data = Notification::find($notification_id);
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
