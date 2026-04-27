<?php 
require_once 'x-head.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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
        <div class="dashboard-content">
            <?php foreach ($devices as $index => $item): ?>
            <div class="dashboard-item" 
            data-cutoff="<?php echo trim(strtolower($item['cutoff'])) ?>"
            data-index="<?php echo $index; ?>"
            data-name="<?php echo trim(strtolower($item['name'])) ?>" >
                <span class="main-item">
                    <span class="device-name"><?php echo $item['name'] ?></span>
                    <span class="device-ip">(<?php echo $item['ip'] ?>)</span>
                    <span class="log-cutoff"><?php echo "Cutoff: " . $item['cutoff'] ?></span>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="js/cutOffChecker.js"></script>
</body>
</html>