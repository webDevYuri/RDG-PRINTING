<?php
session_start();
include '../connection/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /index.php');
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$service = $_POST['service'] ?? '';
$jobInstructions = trim($_POST['job_instructions'] ?? '');
$files   = $_FILES['attachFile'] ?? null;

$errors = [];

if ($name === '') $errors[] = 'Name is required.';
if ($email === '') $errors[] = 'Email is required.';
if ($service === '') $errors[] = 'Service choice is required.';
if ($jobInstructions === '') $errors[] = 'Job instructions are required.';
if (empty($_FILES['attachFile']['name'][0])) {
    $errors[] = 'You must attach at least one file.';
}

$validExt = ['jpg','jpeg','png','doc','docx','pdf'];
if (empty($errors)) {
    foreach ($files['name'] as $idx => $filename) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($ext, $validExt, true)) {
            $errors[] = "File “{$filename}” has an invalid file type.";
            break;
        }
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../../index.php');
    exit;
}

$nameEsc    = mysqli_real_escape_string($conn, $name);
$emailEsc   = mysqli_real_escape_string($conn, $email);
$serviceEsc = mysqli_real_escape_string($conn, $service);
$jobInstEsc = mysqli_real_escape_string($conn, $jobInstructions);

$sql = "
  INSERT INTO `uploads` (`name`, `email`, `service`, `job_instructions`, `isActive`) 
  VALUES ('{$nameEsc}', '{$emailEsc}', '{$serviceEsc}', '{$jobInstEsc}', 1)
";

if (!mysqli_query($conn, $sql)) {
    $_SESSION['errors'] = ['Database error during form insert.'];
    header('Location: ../../index.php');
    exit;
}

$upload_id = mysqli_insert_id($conn);
$baseDir = __DIR__ . '/../../uploads';

if (!is_dir($baseDir)) {
    mkdir($baseDir, 0755, true);
}

foreach ($files['tmp_name'] as $idx => $tmpPath) {
    $origName = basename($files['name'][$idx]);
    $safeName = time() . "_{$idx}_" . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $origName);
    $target   = $baseDir . '/' . $safeName;

    if (!move_uploaded_file($tmpPath, $target)) {
        $_SESSION['errors'] = ["Failed to upload file: {$origName}"];
        header('Location: ../../index.php');
        exit;
    }

    $filePathEsc = mysqli_real_escape_string($conn, 'uploads/' . $safeName);
    $origNameEsc = mysqli_real_escape_string($conn, $origName);

    $sql2 = "
      INSERT INTO `upload_files` (`upload_id`, `file_name`, `file_path`)
      VALUES ({$upload_id}, '{$origNameEsc}', '{$filePathEsc}')
    ";

    if (!mysqli_query($conn, $sql2)) {
        $_SESSION['errors'] = ['Database error during file insert.'];
        header('Location: ../../index.php');
        exit;
    }
}

$_SESSION['success'] = 'Files uploaded successfully!';
header('Location: ../../index.php');
exit;
