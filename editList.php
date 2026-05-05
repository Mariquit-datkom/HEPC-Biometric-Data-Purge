<?php 
require_once 'x-head.php';
require_once 'userHeartbeatChecker.php';

$currentPage = basename($_SERVER['PHP_SELF']);

if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$rawList = $data['storage']->readAndDecrypt('assets/docs/devices.dat');
$safeList = htmlspecialchars(trim($rawList), ENT_QUOTES, 'UTF-8');

$formMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $newContent = trim($_POST['content']);
    $filePath = 'assets/docs/devices.dat';

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $formMsg = "<p style='color: #ef4444;'>Security error: Invalid request source.</p>";
    } else if (empty($newContent)) {
        $formMsg = "<p style='color: #ef4444;'>Error: You cannot save an empty list.</p>";  
    } else {
        $saveStatus = $data['storage']->encryptAndSave($newContent, $filePath);
        if ($saveStatus === false) {       
            $formMsg = "<p style='color: #ef4444;'>Failed to save changes. Check file permissions. </p>"; 
        } else {
            $formMsg = "<p style='color: #22c55e;'>File successfully saved. </p>";
            $rawList = $newContent;
            $safeList = htmlspecialchars(trim($rawList), ENT_QUOTES, 'UTF-8');
            unset($_SESSION['device_list']);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }      
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editList.css?v=<?php echo filemtime('css/editList.css'); ?>">
    <title>Edit Devices - Biometric Data Purge</title>
</head>
<body>
    <?php include 'header.php' ?>
    <?php include 'navPanel.php' ?>
    
    <div class="edit-list-main-container">
        <form method="POST" class="edit-list-form">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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
            <textarea name="content" class="edit-list-text-area" spellcheck="false"><?php echo $safeList; ?></textarea>
        </form>
    </div>

    <script src="js/userHeartbeat.js"></script>
</body>
</html>