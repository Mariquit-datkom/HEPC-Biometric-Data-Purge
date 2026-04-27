<?php
    require_once 'dbConfig.php';
    session_start();

    $username = $_SESSION['username'];
    $sql = "UPDATE users SET ping = :ping, status = :status WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['ping' => '0', 'status' => 'offline' ,'username' => $username]);

    session_unset();
    session_destroy();
?>

<script>
    window.location.href = "login.php";
</script>