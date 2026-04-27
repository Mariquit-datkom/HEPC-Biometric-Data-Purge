<?php
class SecureFileManager {
    private $key;
    private $cipher = "aes-256-cbc";

    public function __construct($secret_key) {
        // The key needs to be exactly 32 bytes for aes-256
        $this->key = hash('sha256', $secret_key, true);
    }

    public function encryptAndSave($data, $filename) {
        $iv_length = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($iv_length);
        
        $encrypted = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
        
        // We store the IV + Encrypted data together
        // The IV is needed later to decrypt it
        return file_put_contents($filename, base64_encode($iv . $encrypted));
    }

    public function readAndDecrypt($filename) {
        if (!file_exists($filename)) return false;
        
        $data = base64_decode(file_get_contents($filename));
        $iv_length = openssl_cipher_iv_length($this->cipher);
        
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);
        
        return openssl_decrypt($encrypted, $this->cipher, $this->key, 0, $iv);
    }
}