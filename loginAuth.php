<?php

    require_once 'dbConfig.php'; // db config
    session_start(); // session fetch

    // Form Submission Authentication
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if (empty($_POST['username']) or empty($_POST['password'])) {
            $_SESSION['error'] = "<p style='color: red; font-size: 13px; font-family: Arial;'> Fill up all fields with necessary information. </p>";
            header("Location: logIn.php");
            exit();
            
        } else if (empty($user) || !password_verify($password, $user['password'])) {            
            $_SESSION['error'] = "<p style='color: red; font-size: 13px; font-family: Arial;'> Invalid username or password. Please try again. </p>";
            header("Location: logIn.php");
            exit();
            
        } else if ($user['status'] !== 'offline') {
            $_SESSION['error'] = "<p style='color: red; font-size: 13px; font-family: Arial;'> User is still logged in another device. Logout and try again. </p>";
            header("Location: logIn.php");
            exit();
            
        } else {
            $_SESSION['username'] = $user['username'];
            $now = time();

            $sql = "UPDATE users SET ping = :ping, status = :status WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['ping' => $now, 'status' => 'online','username' => $username]);

            header("Location: dashboard.php");
            exit();
        }
    }
?>