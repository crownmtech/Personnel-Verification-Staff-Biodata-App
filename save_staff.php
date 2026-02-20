<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: staff_form.php');
    exit;
}

// Ensure upload directories exist
$uploadBase = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
$passportDir = $uploadBase . DIRECTORY_SEPARATOR . 'passports';
$fingerprintDir = $uploadBase . DIRECTORY_SEPARATOR . 'fingerprints';

foreach ([$uploadBase, $passportDir, $fingerprintDir] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

function upload_image($fileKey, $targetDir)
{
    if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
        return [false, 'Upload failed for ' . $fileKey];
    }

    $file = $_FILES[$fileKey];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $ext = strtolower($ext);
    $allowed = ['jpg', 'jpeg', 'png'];
    if (!in_array($ext, $allowed, true)) {
        return [false, 'Invalid file type for ' . $fileKey];
    }

    $safeName = uniqid($fileKey . '_', true) . '.' . $ext;
    $destination = $targetDir . DIRECTORY_SEPARATOR . $safeName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return [false, 'Unable to move uploaded file for ' . $fileKey];
    }

    return [true, 'uploads/' . basename($targetDir) . '/' . $safeName];
}

function save_dataurl_image($dataUrl, $targetDir, $prefix)
{
    if (!preg_match('/^data:image\/(png|jpe?g);base64,/', $dataUrl, $matches)) {
        return [false, 'Invalid image data'];
    }

    $ext = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
    $data = substr($dataUrl, strpos($dataUrl, ',') + 1);
    $data = str_replace(' ', '+', $data);
    $decoded = base64_decode($data);
    if ($decoded === false) {
        return [false, 'Unable to decode image data'];
    }

    $safeName = uniqid($prefix . '_', true) . '.' . $ext;
    $destination = $targetDir . DIRECTORY_SEPARATOR . $safeName;
    if (file_put_contents($destination, $decoded) === false) {
        return [false, 'Unable to save image file'];
    }

    return [true, 'uploads/' . basename($targetDir) . '/' . $safeName];
}

$passportSnapshot = $_POST['passport_snapshot'] ?? '';

if (!empty($passportSnapshot)) {
    list($passportOk, $passportPathOrError) = save_dataurl_image($passportSnapshot, $passportDir, 'passport');
} else {
    $passportOk = false;
    $passportPathOrError = 'No passport snapshot received from camera.';
}

$fingerprintSnapshot = $_POST['fingerprint_snapshot'] ?? '';
if (!empty($fingerprintSnapshot)) {
    if (strpos($fingerprintSnapshot, 'data:image') === 0) {
        // If we ever switch to real scanner data URLs, handle them here
        list($fingerOk, $fingerPathOrError) = save_dataurl_image($fingerprintSnapshot, $fingerprintDir, 'fingerprint');
    } else {
        // Snapshot is a relative path such as images/finger1.jpg, finger2.jpg, etc.
        $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . $fingerprintSnapshot;
        if (is_file($sourcePath)) {
            $ext = pathinfo($sourcePath, PATHINFO_EXTENSION);
            $ext = strtolower($ext) ?: 'png';
            $safeName = uniqid('fingerprint_', true) . '.' . $ext;
            $destination = $fingerprintDir . DIRECTORY_SEPARATOR . $safeName;
            if (@copy($sourcePath, $destination)) {
                $fingerOk = true;
                $fingerPathOrError = 'uploads/' . basename($fingerprintDir) . '/' . $safeName;
            } else {
                $fingerOk = false;
                $fingerPathOrError = 'Unable to copy fingerprint image.';
            }
        } else {
            $fingerOk = false;
            $fingerPathOrError = 'Fingerprint source image not found.';
        }
    }
} else {
    $fingerOk = false;
    $fingerPathOrError = 'No fingerprint snapshot received.';
}

if (!$passportOk) {
    die('Passport error: ' . htmlspecialchars($passportPathOrError));
}
if (!$fingerOk) {
    die('Fingerprint capture error: ' . htmlspecialchars($fingerPathOrError));
}

// Collect form data (basic trimming and uppercasing where appropriate)
$data = [
    'title' => strtoupper(trim($_POST['title'] ?? '')),
    'surname' => strtoupper(trim($_POST['surname'] ?? '')),
    'first_name' => strtoupper(trim($_POST['first_name'] ?? '')),
    'other_name' => strtoupper(trim($_POST['other_name'] ?? '')),
    'date_of_birth' => $_POST['date_of_birth'] ?? null,
    'sex' => $_POST['sex'] ?? null,
    'marital_status' => strtoupper(trim($_POST['marital_status'] ?? '')),
    'state_of_origin' => $_POST['state_of_origin'] ?? '',
    'lga_origin' => $_POST['lga_origin'] ?? '',
    'state_of_origin_address' => strtoupper(trim($_POST['state_of_origin_address'] ?? '')),
    'state_of_residence' => $_POST['state_of_residence'] ?? '',
    'lga_residence' => $_POST['lga_residence'] ?? '',
    'residential_address' => strtoupper(trim($_POST['residential_address'] ?? '')),
    'phone' => trim($_POST['phone'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'psn_no' => strtoupper(trim($_POST['psn_no'] ?? '')),
    'file_no' => strtoupper(trim($_POST['file_no'] ?? '')),
    'rank_position' => strtoupper(trim($_POST['rank_position'] ?? '')),
    'date_of_first_appointment' => $_POST['date_of_first_appointment'] ?? null,
    'gl_level' => strtoupper(trim($_POST['gl_level'] ?? '')),
    'step_level' => strtoupper(trim($_POST['step_level'] ?? '')),
    'salary_structure' => strtoupper(trim($_POST['salary_structure'] ?? '')),
    'cadre' => strtoupper(trim($_POST['cadre'] ?? '')),
    'bank_name' => strtoupper(trim($_POST['bank_name'] ?? '')),
    'account_number' => trim($_POST['account_number'] ?? ''),
    'bvn' => trim($_POST['bvn'] ?? ''),
    'nin' => trim($_POST['nin'] ?? ''),
    'passport_path' => $passportPathOrError,
    'fingerprint_path' => $fingerPathOrError,
];

$sql = "INSERT INTO staff (
            title, surname, first_name, other_name, date_of_birth, sex, marital_status,
            state_of_origin, lga_origin, state_of_origin_address,
            state_of_residence, lga_residence, residential_address,
            phone, email,
            psn_no, file_no, rank_position, date_of_first_appointment, gl_level, step_level, salary_structure, cadre,
            bank_name, account_number, bvn, nin,
            passport_path, fingerprint_path
        ) VALUES (
            :title, :surname, :first_name, :other_name, :date_of_birth, :sex, :marital_status,
            :state_of_origin, :lga_origin, :state_of_origin_address,
            :state_of_residence, :lga_residence, :residential_address,
            :phone, :email,
            :psn_no, :file_no, :rank_position, :date_of_first_appointment, :gl_level, :step_level, :salary_structure, :cadre,
            :bank_name, :account_number, :bvn, :nin,
            :passport_path, :fingerprint_path
        )";

$stmt = $pdo->prepare($sql);
$stmt->execute($data);

header('Location: list_staff.php?saved=1');
exit;
