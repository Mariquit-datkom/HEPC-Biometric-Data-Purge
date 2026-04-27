<?php 
require_once __DIR__ . '/vendor/autoload.php';
require_once 'encryptionAndSaving/secureFileManager.php';
session_start();

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$storage = new SecureFileManager($_ENV['ENCRYPTION_KEY']);

if (!isset($_SESSION['device_list'])) {
    $rawList = $storage->readAndDecrypt('assets/docs/devices.dat');

    $lines = explode("\n", trim($rawList));
    $devicesArray = [];

    foreach ($lines as $line) {
        $parts = explode(" - ", $line, 3);        
        if (count($parts) === 3) {
            $devicesArray[] = [
                'ip' => trim($parts[0]),
                'name' => trim($parts[1]),
                'cutoff' => trim($parts[2])
            ];
        }
    }

    usort($devicesArray, function($a, $b) {
        return strtotime($a['cutoff']) - strtotime($b['cutoff']);
    });

    $_SESSION['device_list'] = $devicesArray;
} 

$devices = $_SESSION['device_list'];
?>

<link rel="stylesheet" href="libs/fontawesome-pro-7.2.0-web/css/all.css">

<link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">