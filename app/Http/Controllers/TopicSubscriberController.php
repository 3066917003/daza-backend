<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\TopicSubscriber;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class TopicSubscriberController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth', [
            'except' => [
                'subscribers',
            ]
        ]);
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
