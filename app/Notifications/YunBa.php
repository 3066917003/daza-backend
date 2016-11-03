<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Topic;
use App\Models\Article;
use App\Models\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as LNNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;

class YunBa extends LNNotification // implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebhookChannel::class];
    }

    public function toWebhook($notifiable)
    {
        $data = $notifiable;

        $from_user = User::find($data->from_user_id);
        $topic     = Topic::find($data->topic_id);
        $article   = Article::find($data->article_id);

        $alert = '';
        $badge = Notification::where('user_id', $data->user_id)->where('unread', true)->count();

        switch ($data->reason) {
            case "followed":
                $alert = $from_user->name . " 关注了你";
                break;
            case "subscribed":
                $alert = $from_user->name . " 订阅了主题《" . $topic->name . "》";
                break;
            case "upvoted":
                $alert = $from_user->name . " 赞了文章《" . $article->title . "》";
                break;
            case "comment":
                $alert = $from_user->name . " 评论了文章《" . $article->title . "》";
                break;
            case "mention":
                $alert = $from_user->name . " ";
                break;
            default:
                break;
        }

        if (strlen($alert) > 0) {
            $data->content = $alert;
        } else {
            $alert = $data->content;
        }

        return WebhookMessage::create()
            ->data([
                'method' => 'publish_to_alias',
                'appkey' => env('YUNBA_APP_KEY'),
                'seckey' => env('YUNBA_SECRET_KEY'),
                'alias' => md5($data->user_id),
                'msg' => json_encode($data),
                'opts' => [
                    "qos" => 1,
                    'time_to_live' => 36000,
                    'apn_json' => [
                        'aps' => [
                            'alert' => $alert,
                            'badge' => $badge,
                            'sound' => 'bingbong.aiff'
                        ]
                    ]
                ]
            ])
            // ->userAgent("Custom-User-Agent")
            ->header('Content-type', 'application/json');
    }
}
