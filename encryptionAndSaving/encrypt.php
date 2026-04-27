<?php 
require_once '../x-head.php';

$plainFile = '../assets/docs/devices.txt';
$secureFile =  '../assets/docs/devices.dat';

if (file_exists($plainFile)) {
    // 1. Grab the current readable data
    $dataToEncrypt = file_get_contents($plainFile);
    
    // 2. Encrypt and save it to the new file
    if ($storage->encryptAndSave($dataToEncrypt, $secureFile)) {
        echo "Successfully encrypted your data! <br>";
        echo "You can now delete '$plainFile' to keep things secure.";
        unset($_SESSION['device_list']);
    } else {
        echo "Failed to save the encrypted file.";
    }
} else {
    echo "Could not find your plain text file. Check the filename!";
}
?>