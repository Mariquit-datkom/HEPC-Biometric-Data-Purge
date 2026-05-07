<?php
require_once 'dbConfig.php';
if (session_status() === PHP_SESSION_NONE) {    
    session_name("BIOMETRIC_DATA_PURGE_SESSION");
    session_start();
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $now = time();
    
    $stmt = $pdo->prepare("UPDATE users SET ping = :ping, status = :status WHERE username = :username");
    $stmt->execute(['ping' => $now, 'status' => 'online', 'username' => $username]);
    
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(401);
}
?>