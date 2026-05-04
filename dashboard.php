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

function getLastRemovalDate(string $name, string $ip) {
    $safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $name);
    $safeIp = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $ip);
    $filename = "assets/docs/history/{$safeName}_({$safeIp}).txt";

    if (file_exists($filename)) {
        $file = fopen($filename, 'r');
        $firstLine = fgets($file);
        fclose($file);
        
        if (preg_match('/\[(.*?)\]/', $firstLine, $match)) {
            $rawDate = $match[1];
            $rawDate = date("F j, Y", strtotime($rawDate));
            return ucfirst($rawDate);
        }
    }
    return 'N/A';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/loading.css">
    <title>Dashboard - Biometric Data Purge</title>
</head>
<body>
    <?php include 'loading.php' ?>
    <?php include 'header.php' ?>
    <?php include 'navPanel.php' ?>
    
    <div class="dashboard-main-container">
        <div class="no-results"> No results found. </div>
        <div class="dashboard-content">
            <?php foreach ($devices as $index => $item): 
                $lastRemovalDate = getLastRemovalDate($item['name'], $item['ip']);
            ?>
            <div class="dashboard-item content-item"
            data-index="<?php echo $index; ?>"
            data-name="<?php echo trim(strtolower($item['name'])) ?>"
            data-ip="<?php echo trim(strtolower($item['ip'])) ?>"
            data-cutoff="<?php echo trim(strtolower($item['cutoff'])) ?>"
            data-last-removal-date="<?php echo $lastRemovalDate ?>">
                <span class="main-item">
                    <span class="device-name"><?php echo $item['name'] ?></span>
                    <span class="device-ip">(<?php echo $item['ip'] ?>)</span>
                    <span class="log-cutoff"><?php echo "Cutoff: " . $item['cutoff'] ?></span>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="modal-overlay" id="modal-overlay">
        <div class="modal-content" id="modal-content">
            <div class="modal-header">
                <div class="modal-device-details">
                    <p id="modal-device-name"></p>
                    <p id="modal-device-ip"></p>
                </div>
                <div class="back-btn-container">
                    <span class="back-btn" id="back-btn">&times;</span>
                </div>
            </div>
            <div class="modal-cutoff-details">
                <div class="last-logs-removal-date-container">
                    <p class="date-header">Last Logs Removal Date</p>
                    <p class="last-logs-removal-date modal-date" id="last-logs-removal-date"></p>
                </div>
                <div class="next-cutoff-date-container">
                    <p class="date-header">Next Cutoff Date</p>
                    <p class="next-cutoff-date modal-date" id="next-cutoff-date"></p>
                </div>
            </div>
            <div class="modal-btn-container">
                <button type="button" class="modal-btn" id="confirm-log-removal-btn" onclick="updateCutoffDate()">Confirm Logs Removal</button>
                <button type="button" class="modal-btn" id="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <script src="js/userHeartbeat.js"></script>
    <script src="js/cutOffChecker.js"></script>
    <script src="js/dashboardModal.js"></script>
    <script src="js/updateCutoffDate.js"></script>
    <script src="js/pushInit.js"></script>

    <script>
        const vapidKey = "<?php echo $_ENV['VAPID_PUBLIC']; ?>";
        initPushNotifications(vapidKey);
    </script>
</body>
</html>