<?php
ob_start();
require_once 'x-head.php';
ob_clean();

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$targetName = $input['name'] ?? null;
$newCutoff = $input['cutoff'] ?? null;
$deviceIp = null;

if (!$targetName || !$newCutoff) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

$devicesList = $_SESSION['device_list'] ?? [];
$found = false;

foreach ($devicesList as &$device) {
    if (trim(strtolower($device['name'])) === trim(strtolower($targetName))) {
        $deviceIp = $device['ip'];
        $device['cutoff'] = $newCutoff;
        $found = true;
        break;
    }
}

if (!$found) {
    echo json_encode(['success' => false, 'message' => 'Device not found in list.']);
    exit;
} 
    
usort($devicesList, function($a, $b) {
    return strtotime($a['cutoff']) - strtotime($b['cutoff']);
});

$_SESSION['device_list'] = $devicesList;

$stringBuffer = "";
foreach ($devicesList as $d) {
    $stringBuffer .= $d['ip'] . " - " . $d['name'] . " - " . $d['cutoff'] . "\n";
}

$saveStatus = $storage->encryptAndSave(trim($stringBuffer), 'assets/docs/devices.dat');

if ($saveStatus === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to write to file.']);
} else {
    try {
        $historyDir = 'assets/docs/history/';
        if (!is_dir($historyDir)) {
            mkdir($historyDir, 0755, true);
        }

        $safeFileName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $targetName) . "_(" . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $deviceIp) . ")";
        $historyFile = $historyDir . $safeFileName . ".txt";

        $timestamp = date("Y-m-d h:i A");
        $user = $_SESSION['username'] ?? 'Admin';
        $newEntry = "[$timestamp] Logs removal confirmed by $user";

        if (file_exists($historyFile)) {
            $existingContent = file_get_contents($historyFile);
            $updatedContent = $newEntry . "\n" . $existingContent;
        } else {
            $updatedContent = $newEntry;
        }

        file_put_contents($historyFile, $updatedContent);
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => true, 'note' => 'Update successful, but history log failed.']);
    }
}

ob_end_flush();
?>