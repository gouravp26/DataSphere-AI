<?php

require_once "../../config/session.php";
require_once "../../config/database.php";
require_once "import_csv.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (
    !isset($_SESSION['import_file']) ||
    !isset($_SESSION['import_dataset_name'])
) {
    header("Location: index.php");
    exit();
}

$filePath = __DIR__ . "/temp/" . $_SESSION['import_file'];

if (!file_exists($filePath)) {
    die("CSV file not found.");
}

try {

    $conn->beginTransaction();

    $handle = fopen($filePath, "r");

    if (!$handle) {
        throw new Exception("Unable to open CSV.");
    }

    /* Read Header */

    $headers = fgetcsv($handle);

    /* Read first row */

    $firstRow = fgetcsv($handle);

    if (!$headers || !$firstRow) {
        throw new Exception("CSV is empty.");
    }

    /* Create Dataset */

    $datasetId = createDataset(
        $conn,
        $_SESSION['import_dataset_name'],
        $_SESSION['user_id']
    );

    /* Create Fields */

    $fieldIds = createFields(
        $conn,
        $datasetId,
        $headers,
        $firstRow
    );

    /*
    |--------------------------------------------------------------------------
    | Import First Row
    |--------------------------------------------------------------------------
    */

    $rows = [];

    $rows[] = $firstRow;

    while (($row = fgetcsv($handle)) !== false) {
        $rows[] = $row;
    }

    fclose($handle);

    foreach ($rows as $row) {

        /*
        | Create Record
        */

$recordId = createRecord(
    $conn,
    $datasetId,
    $_SESSION['user_id']
);

saveRecordValues(
    $conn,
    $recordId,
    $fieldIds,
    $row
);

    }

    /*
    |--------------------------------------------------------------------------
    | Activity Log (optional)
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        INSERT INTO activity_logs
        (user_id, action, description)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        "Import Dataset",
        "Imported dataset: " . $_SESSION['import_dataset_name']
    ]);

    /*
    |--------------------------------------------------------------------------
    | Commit
    |--------------------------------------------------------------------------
    */

    $conn->commit();

    /*
    |--------------------------------------------------------------------------
    | Cleanup
    |--------------------------------------------------------------------------
    */

    unlink($filePath);

    unset($_SESSION['import_file']);
    unset($_SESSION['import_dataset_name']);
    unset($_SESSION['original_file_name']);

    $_SESSION['success'] = "Dataset imported successfully.";

    header("Location: ../records/index.php?dataset_id=" . $datasetId);
    exit();

} catch (Exception $e) {

    if ($conn->inTransaction()) {
    $conn->rollBack();
}

    $_SESSION['error'] = $e->getMessage();

    header("Location: index.php");
    exit();
}