<?php 
require_once 'x-head.php';
require_once 'userHeartbeatChecker.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['username'])) {
    header("Location: login.php?reason=invalid_session");
    exit();
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/history.css">
    <title>History - Biometric Data Purge</title>
</head>
<body>
    <?php include 'header.php' ?>
    <?php include 'navPanel.php' ?>
    
    <div class="history-main-container">
        <div class="history-content">
            <div class="device-list-container">
                <?php foreach ($devices as $index => $item): ?>
                <div class="device"
                data-name="<?php echo trim(strtolower($item['name'])) ?>"
                data-ip="<?php echo trim(strtolower($item['ip'])) ?>">
                    <span class="device-main"><?php echo $item['name'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="date-list-container">
                <p class="history-instructions">Click device name from list to check history.</p>
                <div class="history-container"></div>
            </div>
        </div>
    </div>
    
    <script src="js/userHeartbeat.js"></script>
    <script src="js/historyHandler.js"></script>
</body>
</html>