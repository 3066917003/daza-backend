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
        $result = Notification::find($notification_id);
        if ($result) {
            return $this->success($result);
        }
        return $this->failure();
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
