<?php 
require_once 'x-head.php';
require_once 'userHeartbeatChecker.php';

$currentPage = basename($_SERVER['PHP_SELF']);

$formMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $newContent = trim($_POST['content']);
    $filePath = 'assets/docs/devices.dat';
    $saveStatus = $storage->encryptAndSave($newContent, $filePath);

    if ($saveStatus !== false) {        
        $formMsg = "<p style='color: #22c55e;'>File successfully saved. </p>";
        unset($_SESSION['device_list']);
    } else {
        $formMsg = "<p style='color: #ef4444;'>Failed to save changes. Check file permissions. </p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/editList.css">
    <title>Edit Devices - Biometric Data Purge</title>
</head>
<body>
    <?php include 'header.php' ?>
    <?php include 'navPanel.php' ?>
    
    <div class="edit-list-main-container">
        <form method="POST" class="edit-list-form">
            <div class="top-container">
                <div class="form-header-container">
                    <p class="form-header">Editing devices.dat:</p>
                </div>
                <div class="form-msg-container">
                    <p class="form-msg"><?php echo $formMsg ?></p>
                </div>
                <div class="form-btn-container">
                    <button type="submit" class="form-btn">Save Changes</button>
                </div>
            </div>
            <textarea name="content" class="edit-list-text-area"><?php 
                $rawList = $storage->readAndDecrypt('assets/docs/devices.dat');
                echo htmlspecialchars(trim($rawList));
            ?></textarea>
        </form>
    </div>

    <script src="js/userHeartbeat.js"></script>
</body>
</html>