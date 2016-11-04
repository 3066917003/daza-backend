<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\TopicSubscriber;
use App\Models\Notification;

use DB;
use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;

class TopicSubscriberController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'subscribers',
            ]
        ]);
        // 设置 jwt.try_get_user 中间件，用于尝试通过 Token 获取当前登录用户
        $this->middleware('jwt.try_get_user', ['only' => ['subscribers']]);
    }

    public function subscribers(Request $request, $id)
    {
        $query = TopicSubscriber::with('user')->where('topic_id', $id)
            ->orderBy('created_at', 'desc');

        return $this->pagination($query->paginate());
    }

    public function subscribe(Request $request, $id)
    {
        $request->merge(['topic' => $id]);
        $rules = [
            'topic' => 'exists:topics,id',
        ];
        $this->validate($request, $rules);

        $data = TopicSubscriber::firstOrCreate([
            'user_id'  => Auth::id(),
            'topic_id' => $id
        ]);

        // 更新主题订阅数
        $subscriber_count = TopicSubscriber::where(['topic_id' => $id])->count();
        DB::table('topics')->where('id', $id)->update(['subscriber_count' => $subscriber_count]);

        // 创建一条消息通知
        $topic = Topic::find($id);
        if (Auth::id() !== $topic->user_id) {
            $notification = Notification::create([
                'user_id'      => $topic->user_id,
                'reason'       => 'subscribed',
                'from_user_id' => Auth::id(),
                'topic_id'     => $id,
            ]);
        }
        return $this->success();
    }

    public function unsubscribe(Request $request, $id)
    {
        $request->merge(['topic' => $id]);
        $rules = [
            'topic' => 'exists:topics,id',
        ];
        $this->validate($request, $rules);

        TopicSubscriber::where('user_id', Auth::id())->where('topic_id', $id)->delete();

        return $this->success();
    }

}
