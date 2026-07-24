<?php

require_once "../../config/session.php";
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

$record_id = (int)$_POST['record_id'];
$dataset_id = (int)$_POST['dataset_id'];

$stmt = $conn->prepare("
SELECT id
FROM dataset_fields
WHERE dataset_id=?
");

$stmt->execute([$dataset_id]);

$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($fields as $field){

    $value = $_POST["field_".$field['id']] ?? "";

    $stmt = $conn->prepare("
    UPDATE record_values
    SET value=?
    WHERE record_id=?
    AND field_id=?
    ");

    $stmt->execute([
        $value,
        $record_id,
        $field['id']
    ]);
}

// logActivity(
//     $conn,
//     $_SESSION['user_id'],
//     "UPDATE",
//     "Record",
//     "Updated Record #".$record_id
// );

header("Location: index.php?dataset_id=".$dataset_id);
exit();