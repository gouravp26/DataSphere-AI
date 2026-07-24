<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header("Location: index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Dataset Name
|--------------------------------------------------------------------------
*/

$datasetName = trim($_POST['dataset_name'] ?? '');

if ($datasetName === '') {
    $_SESSION['error'] = "Dataset name is required.";
    header("Location: index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| File Validation
|--------------------------------------------------------------------------
*/

if (!isset($_FILES['csv_file'])) {

    $_SESSION['error'] = "Please choose a CSV file.";

    header("Location: index.php");
    exit();
}

$file = $_FILES['csv_file'];

if ($file['error'] !== UPLOAD_ERR_OK) {

    $_SESSION['error'] = "File upload failed.";

    header("Location: index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Extension Check
|--------------------------------------------------------------------------
*/

$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if ($extension !== "csv") {

    $_SESSION['error'] = "Only CSV files are allowed.";

    header("Location: index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| File Size (20 MB)
|--------------------------------------------------------------------------
*/

$maxSize = 20 * 1024 * 1024;

if ($file['size'] > $maxSize) {

    $_SESSION['error'] = "Maximum file size is 20 MB.";

    header("Location: index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Temp Folder
|--------------------------------------------------------------------------
*/

$tempDirectory = __DIR__ . "/temp/";

if (!is_dir($tempDirectory)) {
    mkdir($tempDirectory, 0777, true);
}

/*
|--------------------------------------------------------------------------
| Generate Unique File Name
|--------------------------------------------------------------------------
*/

$newFileName = uniqid("dataset_", true) . ".csv";

/*
|--------------------------------------------------------------------------
| Move File
|--------------------------------------------------------------------------
*/

if (!move_uploaded_file(
    $file['tmp_name'],
    $tempDirectory . $newFileName
)) {

    $_SESSION['error'] = "Unable to save uploaded file.";

    header("Location: index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Store in Session
|--------------------------------------------------------------------------
*/

$_SESSION['import_dataset_name'] = $datasetName;
$_SESSION['import_file'] = $newFileName;
$_SESSION['original_file_name'] = $file['name'];

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location: preview.php");
exit();