<?php 
session_start();
date_default_timezone_set('Asia/Manila');

$data = require 'devicesInit.php';

if (!isset($_SESSION['device_list'])) $_SESSION['device_list'] = $data['devices'];
$devices = $_SESSION['device_list'];
?>

<link rel="stylesheet" href="libs/fontawesome-pro-7.2.0-web/css/all.css">
<link rel="stylesheet" href="css/global.css?v=<?php echo filemtime('css/global.css'); ?>">

<link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">