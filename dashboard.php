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
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard - Biometric Data Purge</title>
</head>
<body>
    <?php include 'header.php' ?>
    <?php include 'navPanel.php' ?>
    
    <div class="dashboard-main-container">
        <div class="no-results"> No results found. </div>
        <div class="dashboard-content">
            <?php foreach ($devices as $index => $item): ?>
            <div class="dashboard-item content-item"
            data-index="<?php echo $index; ?>"
            data-name="<?php echo trim(strtolower($item['name'])) ?>"
            data-ip="<?php echo trim(strtolower($item['ip'])) ?>"
            data-cutoff="<?php echo trim(strtolower($item['cutoff'])) ?>">
                <span class="main-item">
                    <span class="device-name"><?php echo $item['name'] ?></span>
                    <span class="device-ip">(<?php echo $item['ip'] ?>)</span>
                    <span class="log-cutoff"><?php echo "Cutoff: " . $item['cutoff'] ?></span>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="modal-overlay">
        <div class="modal-content">
            
        </div>
    </div>

    <script src="js/cutOffChecker.js"></script>
    <script src="js/userHeartbeat.js"></script>
</body>
</html>