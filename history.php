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

$companyList = [];
foreach ($devices as $item) {
    $parts = explode(':', $item['name']);
    $group = trim($parts[0]);

    if ($group && !in_array($group, $companyList)) {
        $companyList[] = $group;
    }
}
sort($companyList);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/history.css?v=<?php echo filemtime('css/history.css'); ?>">
    <title>History - Biometric Data Purge</title>
</head>
<body>
    <?php include 'header.php' ?>
    <?php include 'navPanel.php' ?>
    
    <div class="history-main-container">
        <div class="tabs-container">
            <div class="company-tab active-tab" data-company="all">All</div>
            <?php foreach ($companyList as $group): ?>
                <div class="company-tab" data-company="<?php echo strtolower($group); ?>">
                    <?php echo $group; ?> 
                </div>
            <?php endforeach; ?>
        </div>
        <div class="history-content">
            <div class="device-list-container">
                <?php foreach ($devices as $index => $item): ?>
                <div class="device"
                data-name="<?php echo trim(strtolower(str_replace(':', ' ', $item['name']))) ?>"
                data-ip="<?php echo trim(strtolower($item['ip'])) ?>">
                    <span class="device-main"><?php echo str_replace(':', ' ', $item['name']) ?> (<?php echo trim(str_replace('192.168', '', $item['ip'])) ?>)</span>
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
    <script src="js/historyTabs.js"></script>
</body>
</html>