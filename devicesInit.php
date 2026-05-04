<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'encryptionAndSaving/secureFileManager.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$storage = new SecureFileManager($_ENV['ENCRYPTION_KEY']);
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

return ['storage' => $storage, 'devices' => $devicesArray];
?>