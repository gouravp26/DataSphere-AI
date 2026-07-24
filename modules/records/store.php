<?php

require_once "../../config/session.php";
require_once "../../config/constants.php";
require_once "../../config/database.php";
require_once "../../config/activity_logger.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../datasets/index.php");
    exit();
}

$dataset_id = (int)$_POST['dataset_id'];
$user_id = $_SESSION['user_id'];

// Create the record
$stmt = $conn->prepare("
INSERT INTO records (dataset_id, created_by)
VALUES (?, ?)
");

$stmt->execute([
    $dataset_id,
    $user_id
]);

$record_id = $conn->lastInsertId();

// Get all fields
$stmt = $conn->prepare("
SELECT id
FROM dataset_fields
WHERE dataset_id=?
");

$stmt->execute([$dataset_id]);

$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Save every value
foreach($fields as $field){

    $field_id = $field['id'];

    $value = $_POST["field_$field_id"] ?? "";

    $stmt = $conn->prepare("
    INSERT INTO record_values
    (record_id, field_id, value)
    VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $record_id,
        $field_id,
        $value
    ]);

logActivity(
    $conn,
    $_SESSION['user_id'],
    "CREATE",
    "Record",
    "Added record to ".$dataset_id
);

}

header("Location: index.php?dataset_id=".$dataset_id);
exit();