<?php

define('ENCRYPTION_KEY', 'your-32-character-secret-key!!'); // Must be 32 chars

function encryptValue($value)
{
    $iv        = openssl_random_pseudo_bytes(16); // 16 bytes for AES-256-CBC
    $encrypted = openssl_encrypt($value, 'AES-256-CBC', ENCRYPTION_KEY, 0, $iv);
    return base64_encode($iv . $encrypted); // Combine IV + encrypted data
}

function decryptValue($data)
{
    $decoded   = base64_decode($data);
    $iv        = substr($decoded, 0, 16);
    $encrypted = substr($decoded, 16);
    return openssl_decrypt($encrypted, 'AES-256-CBC', ENCRYPTION_KEY, 0, $iv);
}

function setSecureCookie($name, $value, $expiry)
{
    $encryptedValue = encryptValue($value);
    setcookie($name, $encryptedValue, $expiry, "/");
}

function getSecureCookie($name)
{
    if (isset($_COOKIE[$name])) {
        return decryptValue($_COOKIE[$name]);
    }
    return null;
}

function clearSecureCookie($name)
{
    setcookie($name, '', time() - 3600, "/");
}
