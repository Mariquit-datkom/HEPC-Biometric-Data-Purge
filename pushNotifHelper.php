<?php
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

function sendNotification($title, $message, $subscriptions) {
    $auth = [
        'VAPID' => [
            'subject' => $_ENV['VAPID_SUBJECT'],
            'publicKey' => $_ENV['VAPID_PUBLIC'],
            'privateKey' => $_ENV['VAPID_PRIVATE'],
        ],
    ];

    $webPush = new WebPush($auth);

    foreach ($subscriptions as $sub) {
        $subscription = Subscription::create([
        'endpoint'  => $sub['endpoint'],
        'publicKey'  => $sub['p256dh'],
        'authToken' => $sub['auth'],
    ]);
        
        $webPush->queueNotification(
            $subscription,
            json_encode(['title' => $title, 'body' => $message])
        );
    }

    foreach ($webPush->flush() as $report) {
        if (!$report->isSuccess()) {
            // Handle expired/invalid subscriptions here
        }
    }
}