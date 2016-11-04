<?php

namespace App\Observers;

use App\Models\UserConfig;
use App\Models\Notification;
use App\Notifications\YunBa;

class NotificationObserver
{
    public function created(Notification $data)
    {
        $closed = UserConfig::where('user_id', $data->user_id)
            ->where('key', 'notification_' . $data->reason)
            ->where('value', 'false')
            ->exists();

        // 如果该选项已被设置为关闭，则不推送给客户端。
        if ($closed) {
            return;
        }

        $data->notify(new YunBa());
    }
}
