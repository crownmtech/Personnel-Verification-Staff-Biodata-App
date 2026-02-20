<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list_staff.php');
    exit;
}

// Delete passport and fingerprint files
$uploadBase = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
$passportDir = $uploadBase . DIRECTORY_SEPARATOR . 'passports';
$fingerprintDir = $uploadBase . DIRECTORY_SEPARATOR . 'fingerprints';

function delete_files_in_dir($dir)
{
    if (!is_dir($dir)) {
        return;
    }
    foreach (glob($dir . DIRECTORY_SEPARATOR . '*') as $file) {
        if (is_file($file)) {
            @unlink($file);
        }
    }
}

delete_files_in_dir($passportDir);
delete_files_in_dir($fingerprintDir);

// Clear staff table
$pdo->exec('DELETE FROM staff');

header('Location: list_staff.php?reset=1');
exit;
