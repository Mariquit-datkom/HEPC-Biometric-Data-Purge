<?php
ob_start();
require_once 'x-head.php';
ob_clean();

header('Content-Type: application/json');

$name = $_GET['name'] ?? null;
$ip = $_GET['ip'] ?? null;

if (!$name || !$ip) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters.']);
    exit;
}

$safeFileName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $name) . "_(" . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $ip) . ")";
$historyFile = 'assets/docs/history/' . $safeFileName . ".txt";

if (file_exists($historyFile)) {
    $content = file_get_contents($historyFile);
    $lines = explode("\n", trim($content));
    echo json_encode(['success' => true, 'data' => $lines]);
} else {
    echo json_encode(['success' => true, 'data' => [], 'message' => 'No history found.']);
}

ob_flush();
?>