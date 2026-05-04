<?php
require_once 'dbConfig.php'; 
session_start(); 

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['endpoint']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $endpoint = $data['endpoint'];
    $p256dh = $data['keys']['p256dh'];
    $auth = $data['keys']['auth'];

    try {
        $sql = "INSERT INTO user_subscriptions (user_id, endpoint, p256dh, auth) 
                VALUES (:user_id, :endpoint, :p256dh, :auth)
                ON DUPLICATE KEY UPDATE p256dh = :p256dh, auth = :auth";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id'  => $userId,
            ':endpoint' => $endpoint,
            ':p256dh'   => $p256dh,
            ':auth'     => $auth
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Subscription saved.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized or invalid data.']);
}