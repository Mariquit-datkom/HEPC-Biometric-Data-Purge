<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'pushNotifHelper.php';
require_once 'dbConfig.php'; // Ensure this provides a $pdo connection

// Load data using your established initialization logic
$init = require 'devicesInit.php'; 
$devices = $init['devices'];

// 1. Fetch all active subscriptions
$stmt = $pdo->query("SELECT endpoint, p256dh, auth FROM user_subscriptions");
$subs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($subs)) {
    exit("No subscribers to notify.\n");
}

$today = strtotime('today midnight');
$notifiedCount = 0;

// 2. Filter devices that have reached their cutoff
foreach ($devices as $device) {
    $cutoffTimestamp = strtotime($device['cutoff']);
    if ($cutoffTimestamp === false) continue;

    if ($cutoffTimestamp <= $today) {
        sendNotification(
            "Biometric Purge Alert", 
            "Action required: Log removal due for {$device['name']} ({$device['ip']}).", 
            $subs
        );
        $notifiedCount++;
    }
}

if ($notifiedCount > 0) {
    echo "Sent notifications for $notifiedCount devices at " . date('H:i:s') . "\n";
}